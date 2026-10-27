<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use App\Models\Product;
use App\Support\DbGuard;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    private function rules(): array
    {
        return [
            'date'          => 'required|date',
            'name'          => 'required|string|max:255',
            'price'         => 'required|integer|min:0',
            'box_qty'       => 'nullable|integer|min:0',
            'small_box_qty' => 'nullable|integer|min:0',
            'selling_price' => 'required|integer|min:0',
            'photo'         => 'nullable|string',
        ];
    }

    /** Barang dalam satu folder, lengkap dengan modal & laba per pcs dari VIEW v_produk_laba. */
    public function index(Folder $folder): JsonResponse
    {
        $rows = DB::table('products as p')
            ->join('v_produk_laba as v', 'v.id', '=', 'p.id')
            ->where('p.folder_id', $folder->id)
            ->orderByDesc('p.date')
            ->get(['p.*', 'v.modal_per_pcs', 'v.laba_per_pcs']);
        return response()->json($rows);
    }

    public function store(Request $r, Folder $folder): JsonResponse
    {
        $data = $r->validate($this->rules());
        // Aturan lain (nama kosong) dijaga trigger trg_products_bi -> 422 bila dilanggar.
        return response()->json(DbGuard::tx(fn () => $folder->products()->create($data)), 201);
    }

    public function update(Request $r, Product $product): JsonResponse
    {
        $data = $r->validate($this->rules());
        DbGuard::tx(fn () => $product->update($data));
        return response()->json($product->fresh());
    }

    public function destroy(Product $product): JsonResponse
    {
        DbGuard::tx(fn () => $product->delete());   // snapshot dicatat trigger trg_products_ad
        return response()->json(['deleted' => true]);
    }

    /**
     * Impor banyak barang sekaligus — ALL OR NOTHING.
     * Ditulis dengan beginTransaction/commit/rollBack manual supaya alurnya terlihat jelas
     * (hasilnya sama dengan DB::transaction()).
     */
    public function bulkStore(Request $r, Folder $folder): JsonResponse
    {
        $r->validate(['items' => 'required|array|min:1|max:500']);
        $items = collect($r->input('items'))->map(fn ($i) => validator($i, $this->rules())->validate());

        DbGuard::utc();   // jam sesi MySQL = UTC (lihat DbGuard::utc)
        // [TRANSAKSI] manual: BEGIN -> COMMIT / ROLLBACK (contoh yang paling mudah dibaca)
        DB::beginTransaction();                      // [TRANSAKSI] BEGIN
        try {
            foreach ($items as $item) {
                $folder->products()->create($item);  // trigger validasi jalan di setiap baris
            }
            DB::commit();                            // [COMMIT]  semua barang tersimpan sekaligus
        } catch (\Throwable $e) {
            DB::rollBack();                          // [ROLLBACK]  satu baris gagal -> tidak ada yang tersimpan
            if (($e instanceof \Illuminate\Database\QueryException) && ($e->errorInfo[0] ?? '') === '45000') {
                return response()->json(['message' => $e->errorInfo[2], 'saved' => 0], 422);
            }
            throw $e;
        }
        return response()->json(['saved' => $items->count()], 201);
    }
}
