<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use App\Support\DbGuard;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FolderController extends Controller
{
    /** Daftar folder + jumlah barang + total modal (dihitung FUNCTION fn_total_modal_folder di database). */
    public function index(): JsonResponse
    {
        $folders = Folder::query()
            ->withCount('products')
            ->selectRaw('folders.*, fn_total_modal_folder(folders.id) AS total_modal')
            ->latest()->get();
        return response()->json($folders);
    }

    public function store(Request $r): JsonResponse
    {
        $data = $r->validate(['name' => 'required|string|max:255']);
        // Riwayat "Tambah folder" ditulis otomatis oleh trigger trg_folders_ai.
        return response()->json(DbGuard::tx(fn () => Folder::create($data)), 201);
    }

    public function update(Request $r, Folder $folder): JsonResponse
    {
        $data = $r->validate(['name' => 'required|string|max:255']);
        DbGuard::tx(fn () => $folder->update($data));   // trigger trg_folders_au mencatat bila nama berubah
        return response()->json($folder->fresh());
    }

    /** Tandai folder dibuka (untuk kartu "Terakhir Dibuka"). Tidak dicatat di riwayat. */
    public function open(Folder $folder): JsonResponse
    {
        $folder->update(['last_opened_at' => now()]);
        return response()->json($folder);
    }

    /**
     * Hapus folder beserta barangnya dalam SATU transaksi.
     * Snapshot folder + barang disimpan trigger trg_folders_bd sehingga bisa diurungkan.
     */
    public function destroy(Folder $folder): JsonResponse
    {
        DbGuard::tx(fn () => $folder->delete());
        return response()->json(['deleted' => true]);
    }
}
