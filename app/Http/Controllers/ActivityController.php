<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Services\UndoService;
use App\Support\DbGuard;
use Illuminate\Http\JsonResponse;

class ActivityController extends Controller
{
    /** 80 aktivitas terbaru (halaman Riwayat). Baris-baris ini ditulis oleh trigger. */
    public function index(): JsonResponse
    {
        // Tanpa kolom snapshot (bisa berisi foto berukuran MB); cukup penanda has_snapshot. "Urungkan" membaca snapshot di server.
        return response()->json(Activity::select('id', 'type', 'entity', 'entity_id', 'entity_name', 'undone', 'created_at')
            ->selectRaw('(snapshot IS NOT NULL) AS has_snapshot')->orderByDesc('id')->limit(80)->get());
    }

    /** Hapus satu baris riwayat (riwayat saja; data barang/memo tidak tersentuh). */
    public function destroy(int $id): JsonResponse
    {
        DbGuard::tx(fn () => Activity::whereKey($id)->delete());
        return response()->json(['deleted' => true]);
    }

    /** Hapus SEMUA riwayat. Setelah ini tombol "Urungkan" untuk penghapusan lama tidak tersedia lagi. */
    public function clear(): JsonResponse
    {
        DbGuard::tx(fn () => Activity::query()->delete());
        return response()->json(['deleted' => true]);
    }

    /** Tombol "Urungkan" (transaksi + rollback otomatis bila gagal). */
    public function undo(int $id, UndoService $svc): JsonResponse
    {
        return response()->json($svc->undo($id));
    }
}
