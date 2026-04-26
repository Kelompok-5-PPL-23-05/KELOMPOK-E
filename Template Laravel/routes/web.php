<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

// Redirect root ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// Auth routes (guest only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

// Protected routes (harus login)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/nilai', function () {
        // TODO: simpan nilai
        return back()->with('success', 'Nilai berhasil disimpan!');
    })->name('nilai.store');

    Route::get('/admin/siswa', [AdminController::class, 'siswaIndex'])->name('admin.siswa.index');
    Route::post('/admin/siswa/import', [AdminController::class, 'siswaImport'])->name('admin.siswa.import');
   
   
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
