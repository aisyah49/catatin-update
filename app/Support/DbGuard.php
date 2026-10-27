<?php

namespace App\Support;

use Closure;
use Illuminate\Database\QueryException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;

/**
 * Pembungkus transaksi database.
 *
 * COMMIT / ROLLBACK:
 *  - DB::transaction() menjalankan BEGIN, lalu COMMIT bila closure selesai tanpa error.
 *  - Bila ada exception (termasuk SIGNAL dari trigger), Laravel otomatis ROLLBACK:
 *    semua perubahan di dalam closure dibatalkan, tidak ada data setengah jadi.
 *  - Error dari trigger (SQLSTATE 45000) diubah menjadi respons 422 dengan pesan yang ramah.
 */
class DbGuard
{
    private static bool $utcSet = false;

    /**
     * Samakan zona waktu sesi MySQL dengan Laravel (UTC). Tanpa ini, NOW() di dalam TRIGGER memakai jam komputer
     * (WIB), sementara Laravel menganggapnya UTC, sehingga jam di halaman Riwayat bergeser 7 jam.
     */
    public static function utc(): void
    {
        if (!self::$utcSet) {
            DB::statement("SET time_zone = '+00:00'");
            self::$utcSet = true;
        }
    }

    public static function tx(Closure $work, int $attempts = 1)
    {
        self::utc();
        try {
            // [TRANSAKSI] BEGIN otomatis di sini.
            // [COMMIT]    otomatis bila closure $work selesai tanpa error.
            // [ROLLBACK]  otomatis bila closure melempar error -> semua perubahan dibatalkan.
            return DB::transaction($work, $attempts);   // $attempts > 1 = ulangi otomatis saat deadlock
        } catch (QueryException $e) {
            if (($e->errorInfo[0] ?? null) === '45000') {       // pesan dari SIGNAL di trigger
                throw new HttpResponseException(response()->json([
                    'message' => $e->errorInfo[2] ?? 'Data tidak valid',
                ], 422));
            }
            throw $e;
        }
    }

    /**
     * Jalankan $work dengan pencatatan riwayat otomatis DIMATIKAN (variabel sesi @catatin_skip_log).
     * Dipakai saat "Urungkan": memulihkan data tidak boleh dicatat sebagai "Tambah" baru.
     * Variabel selalu dikembalikan ke 0 di `finally`, walau terjadi error.
     */
    public static function withoutLog(Closure $work)
    {
        DB::statement('SET @catatin_skip_log = 1');
        try {
            return $work();
        } finally {
            DB::statement('SET @catatin_skip_log = 0');
        }
    }
}
