<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\PloController;
use App\Http\Controllers\CloController;
use App\Http\Controllers\AssessmentToolController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MahasiswaController;
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
    Route::get('/nilai/input', [NilaiController::class, 'inputForm'])->name('nilai.input');
    Route::post('/nilai/input', [NilaiController::class, 'storeOrUpdate'])->name('nilai.store');
    Route::get('/nilai/{idMahasiswa}/plo/{idPlo}', [NilaiController::class, 'show'])->name('nilai.show');

    Route::get('/mata-kuliah', [MataKuliahController::class, 'index'])->name('mata-kuliah.index');
    Route::post('/mata-kuliah', [MataKuliahController::class, 'store'])->name('mata-kuliah.store');
    Route::put('/mata-kuliah/{id}', [MataKuliahController::class, 'update'])->name('mata-kuliah.update');
    Route::delete('/mata-kuliah/{id}', [MataKuliahController::class, 'destroy'])->name('mata-kuliah.destroy');

    Route::get('/mata-kuliah/lihat', [MataKuliahController::class, 'lihat'])->name('mata-kuliah.lihat.ui');

    Route::get('/mata-kuliah/manage-plo', [PloController::class, 'managePlo'])->name('mata-kuliah.manage-plo.ui');
    Route::post('/plo-mapping', [PloController::class, 'attachClo'])->name('plo-mapping.attach');
    Route::delete('/plo-mapping/{pivotId}', [PloController::class, 'detachClo'])->name('plo-mapping.detach');

    Route::get('/plo', [PloController::class, 'index'])->name('plo.index');
    Route::post('/plo', [PloController::class, 'store'])->name('plo.store');
    Route::put('/plo/{id}', [PloController::class, 'update'])->name('plo.update');
    Route::delete('/plo/{id}', [PloController::class, 'destroy'])->name('plo.destroy');

    Route::post('/clo', [CloController::class, 'store'])->name('clo.store');
    Route::put('/clo/{id}', [CloController::class, 'update'])->name('clo.update');
    Route::delete('/clo/{id}', [CloController::class, 'destroy'])->name('clo.destroy');

    Route::get('/assessment-tools', [AssessmentToolController::class, 'index'])->name('assessment-tools.index');
    Route::post('/assessment-tools', [AssessmentToolController::class, 'store'])->name('assessment-tools.store');
    Route::put('/assessment-tools/{id}', [AssessmentToolController::class, 'update'])->name('assessment-tools.update');
    Route::delete('/assessment-tools/{id}', [AssessmentToolController::class, 'destroy'])->name('assessment-tools.destroy');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::post('/users/{id}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::get('/mahasiswa', [MahasiswaController::class, 'index'])->name('mahasiswa.index');
    Route::post('/mahasiswa', [MahasiswaController::class, 'store'])->name('mahasiswa.store');
    Route::put('/mahasiswa/{id}', [MahasiswaController::class, 'update'])->name('mahasiswa.update');
    Route::delete('/mahasiswa/{id}', [MahasiswaController::class, 'destroy'])->name('mahasiswa.destroy');

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
