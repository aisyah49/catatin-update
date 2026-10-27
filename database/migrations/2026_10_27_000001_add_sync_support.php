<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * SINKRONISASI Android <-> server.
 *  - kolom `version` (naik 1 setiap data diubah) dipakai untuk mendeteksi KONFLIK: dua perangkat mengubah data yang sama.
 *  - tabel `sync_tombstones` mencatat data yang DIHAPUS, supaya perangkat lain tahu harus ikut menghapus.
 */
return new class extends Migration
{
    private const DATA_TABLES = ['folders', 'products', 'memos', 'sheets'];

    public function up(): void
    {
        foreach (self::DATA_TABLES as $t) {
            if (!Schema::hasColumn($t, 'version')) {
                Schema::table($t, fn (Blueprint $b) => $b->unsignedInteger('version')->default(1));
            }
        }
        if (!Schema::hasTable('sync_tombstones')) {
            Schema::create('sync_tombstones', function (Blueprint $t) {
                $t->id();
                $t->unsignedBigInteger('user_id');
                $t->string('entity', 20);
                $t->string('client_uid', 40)->nullable();
                $t->unsignedBigInteger('record_id');
                $t->unsignedInteger('version')->default(1);
                $t->timestamp('deleted_at')->useCurrent();
                $t->index(['user_id', 'deleted_at']);
                $t->index(['user_id', 'entity', 'client_uid']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('sync_tombstones');
        foreach (self::DATA_TABLES as $t) {
            if (Schema::hasColumn($t, 'version')) {
                Schema::table($t, fn (Blueprint $b) => $b->dropColumn('version'));
            }
        }
    }
};
