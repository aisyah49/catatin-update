<?php

namespace App\Support;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * `php artisan catatin:setup` — menyiapkan database SEPENUHNYA OTOMATIS, aman dijalankan tiap kali aplikasi start:
 *
 *  - Database kosong            -> semua tabel, function, view, trigger dibuat (lewat migration).
 *  - Database hasil import .sql -> tabel yang sudah ada TIDAK dibuat ulang (dicatat sebagai "sudah dimigrasi"),
 *                                  hanya bagian yang baru (login, anti-dobel) yang ditambahkan. Data tetap utuh.
 *  - Database sudah terbaru     -> tidak ada yang berubah.
 * Jadi file .sql tidak perlu diimpor lagi.
 */
class CatatinSetup
{
    /** migration lama => tabel yang dibuatnya (bila semua tabel itu sudah ada, migration dianggap sudah jalan). */
    private const BASELINE = [
        '0001_01_01_000000_create_users_table'                   => ['users', 'password_reset_tokens', 'sessions'],
        '0001_01_01_000001_create_cache_table'                   => ['cache', 'cache_locks'],
        '0001_01_01_000002_create_jobs_table'                    => ['jobs', 'job_batches', 'failed_jobs'],
        '2026_10_22_000001_create_catatin_tables'                => ['folders', 'products', 'memos', 'sheets', 'activities'],
        '2026_10_22_075743_create_personal_access_tokens_table'  => ['personal_access_tokens'],
    ];

    public static function run(Command $cmd): int
    {
        // 1. Tunggu database siap (saat deploy, MySQL kadang baru menyala beberapa detik setelah aplikasi)
        for ($i = 1; ; $i++) {
            try { DB::connection()->getPdo(); break; }
            catch (\Throwable $e) {
                if ($i >= 20) { $cmd->error('Tidak bisa terhubung ke database: ' . $e->getMessage()); return 1; }
                $cmd->warn("Menunggu database ($i/20)...");
                sleep(3);
            }
        }
        $cmd->info('Database terhubung (' . DB::getDriverName() . ').');

        // 2. Bila v_produk_laba tersisa sebagai TABEL (hasil import HeidiSQL yang terpotong), hapus agar bisa dibuat sebagai VIEW
        if (DB::getDriverName() === 'mysql') {
            $t = DB::selectOne("SELECT TABLE_TYPE AS t FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'v_produk_laba'");
            if ($t && $t->t === 'BASE TABLE') {
                DB::statement('DROP TABLE v_produk_laba');
                $cmd->line('v_produk_laba (tabel sementara) dihapus, akan dibuat ulang sebagai view.');
            }
        }

        // 3. Catat migration lama yang tabelnya sudah ada (database hasil import) supaya tidak dibuat ulang
        if (!Schema::hasTable('migrations')) {
            $cmd->call('migrate:install');
        }
        foreach (self::BASELINE as $name => $tables) {
            $ada = collect($tables)->every(fn ($tb) => Schema::hasTable($tb));
            $sudah = DB::table('migrations')->where('migration', $name)->exists();
            if ($ada && !$sudah) {
                DB::table('migrations')->insert(['migration' => $name, 'batch' => 1]);
                $cmd->line("Sudah ada di database, dilewati: $name");
            }
        }

        // 4. Jalankan migration yang belum jalan
        $code = $cmd->call('migrate', ['--force' => true]);
        $cmd->line(trim(\Illuminate\Support\Facades\Artisan::output()));
        if ($code !== 0) {
            $cmd->error('Migration gagal.');
            return 1;
        }

        // 5. Akun bawaan. Dibuat sekali; data lama (user_id kosong) menjadi miliknya. Akun lain yang daftar mulai kosong.
        self::seedDefaultUser($cmd);

        $cmd->info('Database siap.');
        return 0;
    }

    public const DEFAULT_EMAIL = 'user@gmail.com';
    public const DEFAULT_PASSWORD = 'usercatatin';

    private static function seedDefaultUser(Command $cmd): void
    {
        if (!\Illuminate\Support\Facades\Schema::hasColumn('folders', 'user_id')) {
            return;
        }
        $user = \App\Models\User::where('email', self::DEFAULT_EMAIL)->first();
        if ($user) {
            $cmd->line('Akun bawaan sudah ada: ' . self::DEFAULT_EMAIL);
            return;
        }
        $user = \App\Models\User::create([
            'name' => 'User', 'email' => self::DEFAULT_EMAIL, 'password' => self::DEFAULT_PASSWORD,
        ]);
        self::claimOrphans($user->id);
        $cmd->info('Akun bawaan dibuat: ' . self::DEFAULT_EMAIL);
    }

    /** Data lama (dibuat sebelum ada login, user_id masih kosong) diserahkan ke satu akun. */
    public static function claimOrphans(int $userId): void
    {
        DbGuard::utc();
        DbGuard::withoutLog(function () use ($userId) {          // jangan catat sebagai "Ubah" di riwayat
            DB::transaction(function () use ($userId) {
                foreach (['folders', 'products', 'memos', 'sheets', 'activities'] as $t) {
                    DB::table($t)->whereNull('user_id')->update(['user_id' => $userId]);
                }
            });
        });
    }
}
