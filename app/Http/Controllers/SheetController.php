<?php

namespace App\Http\Controllers;

use App\Models\Sheet;
use App\Services\SheetMemoService;
use App\Support\DbGuard;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SheetController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Sheet::select('id', 'name', 'rows', 'cols', 'updated_at')->latest()->get());
    }

    public function store(Request $r): JsonResponse
    {
        $data = $r->validate(['name' => 'required|string|max:255']);
        return response()->json(DbGuard::tx(fn () => Sheet::create($data + ['rows' => 8, 'cols' => 6, 'cells' => []])), 201);
    }

    public function show(Sheet $sheet): JsonResponse
    {
        return response()->json($sheet);
    }

    /** Simpan isi tabel (dipanggil autosave). Tidak dicatat di riwayat. */
    public function update(Request $r, Sheet $sheet): JsonResponse
    {
        $data = $r->validate([
            'name' => 'sometimes|string|max:255', 'rows' => 'sometimes|integer|min:1|max:1000', 'cols' => 'sometimes|integer|min:1|max:100',
            'cells' => 'nullable|array', 'fmt' => 'nullable|array', 'imgs' => 'nullable|array', 'filter' => 'nullable|array',
        ]);
        DbGuard::tx(fn () => $sheet->update($data));
        return response()->json($sheet->fresh());
    }

    public function destroy(Sheet $sheet): JsonResponse
    {
        DbGuard::tx(fn () => $sheet->delete());
        return response()->json(['deleted' => true]);
    }

    /** Salin tabel menjadi Memo baru (lihat SheetMemoService). */
    public function copyToMemo(Sheet $sheet, SheetMemoService $svc): JsonResponse
    {
        return response()->json($svc->copy($sheet), 201);
    }
}
