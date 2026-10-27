<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Data milik satu pengguna.
 *  - Setiap query otomatis ditambah  WHERE user_id = <pengguna yang login>  (global scope),
 *    jadi pengguna A tidak pernah bisa melihat / mengubah / menghapus data pengguna B.
 *  - Saat data dibuat, kolom user_id diisi otomatis dengan pengguna yang sedang login.
 *  - Di terminal (artisan) scope tidak dipasang supaya seeder dan perintah perawatan tetap jalan.
 */
trait BelongsToUser
{
    protected static function bootBelongsToUser(): void
    {
        static::addGlobalScope('mine', function (Builder $q) {
            if (Auth::check()) {
                $q->where($q->getModel()->qualifyColumn('user_id'), Auth::id());
            } elseif (!app()->runningInConsole()) {
                $q->whereRaw('1 = 0');           // belum login: tidak ada data yang boleh terlihat
            }
        });

        static::creating(function ($model) {
            if (Auth::check() && empty($model->user_id)) {
                $model->user_id = Auth::id();
            }
        });

        // SINKRONISASI: setiap perubahan menaikkan `version` (dasar deteksi konflik).
        static::updating(function ($model) {
            if (array_key_exists('version', $model->getAttributes())) {
                $model->version = (int) $model->getOriginal('version') + 1;
            }
        });

        // SINKRONISASI: catat data yang dihapus supaya perangkat lain ikut menghapusnya.
        static::deleted(function ($model) {
            if (!array_key_exists('version', $model->getAttributes()) || empty($model->user_id)) {
                return;                                  // activities tidak ikut sinkron
            }
            if (!Schema::hasTable('sync_tombstones')) {
                return;
            }
            DB::table('sync_tombstones')->insert([
                'user_id' => $model->user_id, 'entity' => $model->getTable(), 'client_uid' => $model->client_uid,
                'record_id' => $model->getKey(), 'version' => (int) $model->version, 'deleted_at' => now(),
            ]);
        });
    }
}
