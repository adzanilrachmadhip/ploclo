<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Services\PloCalculationService;
use App\Http\Controllers\NilaiController;

Route::get('/', [HomeController::class, 'index'])->name('home');



// autenrtikasi
Route::get('/login', [LoginController::class, 'showLogin'])->name('login.form');
Route::post('/login', [LoginController::class, 'handleLogin'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// TESTING UI LOGIN BARU
Route::get('/login-ui', function () {
    return view('auth.login_nw');
})->name('login.ui');

Route::get('/dashboard-ui', function () {
    return view('dashboard.index_nw');
})->name('dashboard.ui');

Route::get('/nilai-ui', function () {
    return view('nilai.index_nw');
})->name('nilai.ui');

Route::get('/nilai-detail-ui', function () {
    return view('nilai.show_nw');
})->name('nilai.detail.ui');

Route::get('/mata-kuliah-ui', function () {
    return view('mata-kuliah.index');
})->name('mata-kuliah.index');

Route::get('/mata-kuliah/lihat_mk_nw-ui', function () {
    return view('mata-kuliah.lihat_nw');
})->name('mata-kuliah.lihat.ui');

Route::get('/mata-kuliah/manage-plo-ui', function () {
    return view('mata-kuliah.manage_plo_nw');
})->name('mata-kuliah.manage-plo.ui');

Route::get('/rps-ui', function () {
    return view('rps.index_nw');
})->name('rps.index');


// dashboard
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [HomeController::class, 'index'])
        ->name('dashboard');

    // NILAI
    Route::get('/nilai', [NilaiController::class, 'index'])
        ->name('nilai.index');

    Route::get('/nilai/{idMahasiswa}/plo/{idPlo}', [NilaiController::class, 'show'])
        ->name('nilai.show');
});



// test plo
Route::get('/test-plo/{id}', function ($id) {

    $service = new PloCalculationService();

    return $service->calculate($id);
});



// JWT API
use App\Http\Controllers\Auth\JwtAuthController;
use App\Http\Middleware\JwtMiddleware;
use App\Http\Middleware\RoleMiddleware;

Route::post('/api/login', [JwtAuthController::class, 'login'])
    ->name('api.login');

Route::middleware([JwtMiddleware::class])->group(function () {

    Route::get('/api/user', [JwtAuthController::class, 'me'])
        ->name('api.me');

    Route::post('/api/logout', [JwtAuthController::class, 'logout'])
        ->name('api.logout');

    Route::get('/api/admin-only', function () {
        return response()->json(['ok' => 'admin']);
    })->middleware([RoleMiddleware::class . ':admin']);

    Route::get('/api/kaprodi-only', function () {
        return response()->json(['ok' => 'kaprodi']);
    })->middleware([RoleMiddleware::class . ':kaprodi']);

    Route::get('/api/dosenwali-only', function () {
        return response()->json(['ok' => 'dosen wali']);
    })->middleware([RoleMiddleware::class . ':dosen wali']);
});



// 404
Route::fallback(function () {
    return response()->view('404', [], 404);
});
