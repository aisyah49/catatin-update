<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// ---- Belum login: halaman masuk & daftar ----
Route::middleware('guest')->group(function () {
    Route::get('/masuk', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/masuk', [AuthController::class, 'login'])->middleware('throttle:10,1');   // batasi tebak kata sandi
    Route::get('/daftar', [AuthController::class, 'showRegister']);
    Route::post('/daftar', [AuthController::class, 'register'])->middleware('throttle:10,1');
});

// ---- Sudah login: aplikasi Catatin + datanya ----
Route::middleware('auth')->group(function () {
    Route::view('/', 'catatin');
    Route::post('/keluar', [AuthController::class, 'logout']);
    Route::get('/api/me', [AuthController::class, 'me']);

    // Semua data lewat /api/... dan memakai sesi login yang sama (cookie + token CSRF), lihat routes/catatin.php.
    Route::prefix('api')->group(base_path('routes/catatin.php'));
});
