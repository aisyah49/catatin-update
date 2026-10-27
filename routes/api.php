<?php

use App\Http\Controllers\Api\MobileAuthController;
use App\Http\Controllers\SyncController;
use Illuminate\Support\Facades\Route;

/*
 * API untuk aplikasi Android (TANPA sesi/cookie): memakai token Sanctum.
 * (Alamat web biasa /api/db/... ada di routes/catatin.php dan memakai sesi login.)
 */
Route::post('auth/token', [MobileAuthController::class, 'token'])->middleware('throttle:6,1');   // masuk: maks 6 percobaan / menit

Route::middleware(['auth:sanctum', 'abilities:sync', 'throttle:120,1'])->group(function () {
    Route::get('sync/ping', [SyncController::class, 'ping']);
    Route::post('sync', [SyncController::class, 'sync']);
    Route::post('auth/refresh', [MobileAuthController::class, 'refresh']);
    Route::post('auth/logout', [MobileAuthController::class, 'logout']);
});
