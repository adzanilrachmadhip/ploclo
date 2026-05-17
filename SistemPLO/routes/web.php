<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');


// Authentication routes
Route::get('/login', [LoginController::class, 'showLogin'])->name('login.form');
Route::post('/login', [LoginController::class, 'handleLogin'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Dashboard (protected route)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
});

// Fallback route to show 404 view
Route::fallback(function () {
    return response()->view('404', [], 404);
});

// JWT API routes
use App\Http\Controllers\Auth\JwtAuthController;
use App\Http\Middleware\JwtMiddleware;
use App\Http\Middleware\RoleMiddleware;

Route::post('/api/login', [JwtAuthController::class, 'login'])->name('api.login');
Route::middleware([JwtMiddleware::class])->group(function () {
    Route::get('/api/user', [JwtAuthController::class, 'me'])->name('api.me');
    Route::post('/api/logout', [JwtAuthController::class, 'logout'])->name('api.logout');

    // Example protected routes by role
    Route::get('/api/admin-only', function () { return response()->json(['ok' => 'admin']); })->middleware([RoleMiddleware::class . ':admin']);
    Route::get('/api/kaprodi-only', function () { return response()->json(['ok' => 'kaprodi']); })->middleware([RoleMiddleware::class . ':kaprodi']);
    Route::get('/api/dosenwali-only', function () { return response()->json(['ok' => 'dosen wali']); })->middleware([RoleMiddleware::class . ':dosen wali']);
});
