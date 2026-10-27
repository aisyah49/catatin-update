<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\MemoController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SheetController;
use Illuminate\Support\Facades\Route;

// Semua alamat di file ini diawali /api dan hanya bisa diakses setelah login (lihat routes/web.php).
// Dimuat dari routes/web.php (grup "web" = ada sesi + CSRF), bukan dari grup "api" bawaan Laravel.

Route::apiResource('folders', FolderController::class)->except('show');
Route::post('folders/{folder}/open', [FolderController::class, 'open']);

// Barang selalu berada di dalam folder
Route::get('folders/{folder}/products', [ProductController::class, 'index']);
Route::post('folders/{folder}/products', [ProductController::class, 'store']);
Route::post('folders/{folder}/products/bulk', [ProductController::class, 'bulkStore']);   // impor all-or-nothing
Route::put('products/{product}', [ProductController::class, 'update']);
Route::delete('products/{product}', [ProductController::class, 'destroy']);

Route::apiResource('memos', MemoController::class)->except('show');

Route::apiResource('sheets', SheetController::class);
Route::post('sheets/{sheet}/copy-to-memo', [SheetController::class, 'copyToMemo']);

Route::get('activities', [ActivityController::class, 'index']);
Route::post('activities/{id}/undo', [ActivityController::class, 'undo']);
Route::delete('activities/{id}', [ActivityController::class, 'destroy'])->whereNumber('id');
Route::delete('activities', [ActivityController::class, 'clear']);

// ---- Pintu data untuk tampilan Catatin (lihat UiStoreController) ----
use App\Http\Controllers\UiStoreController;

Route::prefix('db')->group(function () {
    $entities = ['folders', 'products', 'memos', 'sheets'];
    Route::get('bundle', [UiStoreController::class, 'bundle']);                                   // semua daftar dalam 1 permintaan
    Route::get('products-photos/{folder}', [UiStoreController::class, 'productPhotos'])->whereNumber('folder');
    Route::get('{entity}', [UiStoreController::class, 'index'])->whereIn('entity', $entities);
    Route::get('{entity}/{id}', [UiStoreController::class, 'show'])->whereIn('entity', $entities)->whereNumber('id');
    Route::post('{entity}', [UiStoreController::class, 'save'])->whereIn('entity', $entities);
    Route::put('{entity}/{id}', [UiStoreController::class, 'save'])->whereIn('entity', $entities)->whereNumber('id');
    Route::delete('{entity}/{id}', [UiStoreController::class, 'destroy'])->whereIn('entity', $entities)->whereNumber('id');
});
