<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AbsensiController;

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

    // ─── Guru Dashboard ───────────────────────────────────────
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ─── Nilai ────────────────────────────────────────────────
    Route::post('/nilai', function () {
        return back()->with('success', 'Nilai berhasil disimpan!');
    })->name('nilai.store');

    // ─── Absensi (PPLE-66, 67, 68, 69) ───────────────────────
    Route::get('/absensi',        [AbsensiController::class, 'index']) ->name('absensi.index');
    Route::post('/absensi',       [AbsensiController::class, 'store']) ->name('absensi.store');
    Route::get('/absensi/rekap',  [AbsensiController::class, 'rekap']) ->name('absensi.rekap');

    // ─── Admin Dashboard ──────────────────────────────────────
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
