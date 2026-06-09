<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\Auth\JwtAuthController;
use App\Http\Middleware\JwtMiddleware;
use App\Http\Middleware\RoleMiddleware;

// Autentikasi
Route::get('/login', [LoginController::class, 'showLogin'])->name('login.form');
Route::post('/login', [LoginController::class, 'handleLogin'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Protected web routes
Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    Route::get('/nilai', [NilaiController::class, 'index'])->name('nilai.index');
    Route::get('/nilai/{idMahasiswa}/plo/{idPlo}', [NilaiController::class, 'show'])->name('nilai.show');

    Route::get('/mata-kuliah', function () {
        return view('mata-kuliah.index');
    })->name('mata-kuliah.index');

    Route::get('/mata-kuliah/lihat', function () {
        return view('mata-kuliah.lihat_nw');
    })->name('mata-kuliah.lihat.ui');

    Route::get('/mata-kuliah/manage-plo', function () {
        return view('mata-kuliah.manage_plo_nw');
    })->name('mata-kuliah.manage-plo.ui');

    Route::get('/rps', function () {
        return view('rps.index_nw');
    })->name('rps.index');
});

// JWT API routes
Route::post('/api/login', [JwtAuthController::class, 'login'])->name('api.login');

Route::middleware([JwtMiddleware::class])->group(function () {
    Route::get('/api/user', [JwtAuthController::class, 'me'])->name('api.me');
    Route::post('/api/logout', [JwtAuthController::class, 'logout'])->name('api.logout');

    Route::get('/api/admin-only', function () {
        return response()->json(['ok' => 'admin']);
    })->middleware([RoleMiddleware::class . ':admin']);

    Route::get('/api/kaprodi-only', function () {
        return response()->json(['ok' => 'kaprodi']);
    })->middleware([RoleMiddleware::class . ':kaprodi']);
});

// 404
Route::fallback(function () {
    return response()->view('404', [], 404);
});
