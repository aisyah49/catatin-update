<?php

namespace App\Services;

use App\Models\Activity;
use App\Models\Folder;
use App\Models\Memo;
use App\Models\Product;
use App\Support\DbGuard;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * "Urungkan" penghapusan — satu TRANSAKSI utuh:
 *   BEGIN -> kunci baris riwayat -> pulihkan data -> tandai undone -> COMMIT
 * Bila salah satu langkah gagal (mis. ID sudah dipakai data lain), semuanya ROLLBACK
 * sehingga folder tidak terpulihkan setengah-setengah (folder ada tapi barangnya hilang).
 */
class UndoService
{
    public function undo(int $activityId): Activity
    {
        return DbGuard::tx(function () use ($activityId) {
            // [TRANSAKSI] seluruh isi closure = 1 transaksi (DbGuard::tx). Error di mana pun -> [ROLLBACK] otomatis,
            // jadi data tidak pernah setengah dipulihkan; selesai normal -> [COMMIT].
            // lockForUpdate: cegah dua permintaan "Urungkan" berbarengan memulihkan data dua kali.
            $a = Activity::lockForUpdate()->findOrFail($activityId);

            if ($a->type !== 'delete' || !$a->snapshot || $a->undone) {
                $this->fail('Aktivitas ini tidak bisa diurungkan');
            }

            DbGuard::withoutLog(function () use ($a) {
                $s = $a->snapshot;
                match ($a->entity) {
                    'folder'  => $this->restoreFolder($s),
                    'product' => Product::create($s),
                    'memo'    => Memo::create($s),
                    default   => $this->fail('Jenis data ini tidak bisa diurungkan'),
                };
            });

            $a->update(['undone' => true]);   // hanya kolom `undone` yang boleh berubah (dijaga trigger)
            return $a->fresh();
        });
    }

    private function restoreFolder(array $s): void
    {
        $folder = Folder::create($s['folder']);                 // id lama dipakai lagi
        foreach ($s['products'] ?? [] as $p) {
            Product::create($p);                                // bila satu gagal -> seluruh transaksi ROLLBACK
        }
    }

    private function fail(string $msg): never
    {
        throw new HttpResponseException(response()->json(['message' => $msg], 422));
    }
}
