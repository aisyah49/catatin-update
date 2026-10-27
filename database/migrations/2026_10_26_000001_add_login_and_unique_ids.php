<?php

use App\Support\CatatinTriggers;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Tambahan untuk fitur LOGIN pengguna dan anti-data-dobel.
 *
 *  1. Kolom user_id di semua tabel data  -> tiap pengguna hanya melihat datanya sendiri.
 *  2. Kolom client_uid (unik) di folders/products/memos/sheets -> bila aplikasi (karena internet lambat) mengirim
 *     permintaan "buat baru" dua kali, database tetap hanya membuat SATU baris.
 *  3. Trigger riwayat dibuat ulang supaya ikut mencatat user_id.
 *
 * Aman dijalankan pada database lama: setiap perubahan dicek dulu (hasColumn) sehingga tidak error bila sudah ada,
 * dan semua data yang sudah ada tetap utuh.
 */
return new class extends Migration
{
    private const DATA_TABLES = ['folders', 'products', 'memos', 'sheets'];

    public function up(): void
    {
        foreach (array_merge(self::DATA_TABLES, ['activities']) as $t) {
            if (!Schema::hasColumn($t, 'user_id')) {
                Schema::table($t, function (Blueprint $b) {
                    $b->unsignedBigInteger('user_id')->nullable()->index();
                });
            }
        }
        foreach (self::DATA_TABLES as $t) {
            if (!Schema::hasColumn($t, 'client_uid')) {
                Schema::table($t, function (Blueprint $b) use ($t) {
                    $b->string('client_uid', 40)->nullable();
                    $b->unique(['user_id', 'client_uid'], "{$t}_user_uid_unique");   // unik PER USER
                });
            }
        }

        if (DB::getDriverName() === 'mysql') {
            CatatinTriggers::install();      // trigger versi 2 (mencatat user_id)
        }
    }

    public function down(): void
    {
        foreach (self::DATA_TABLES as $t) {
            if (Schema::hasColumn($t, 'client_uid')) {
                Schema::table($t, fn (Blueprint $b) => $b->dropColumn('client_uid'));
            }
        }
        foreach (array_merge(self::DATA_TABLES, ['activities']) as $t) {
            if (Schema::hasColumn($t, 'user_id')) {
                Schema::table($t, fn (Blueprint $b) => $b->dropColumn('user_id'));
            }
        }
    }
};
