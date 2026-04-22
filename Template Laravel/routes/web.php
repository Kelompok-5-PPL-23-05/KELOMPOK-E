<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\NilaiController;

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

    // ─── Absensi ──────────────────────────────────────────────
    Route::get('/absensi',        [AbsensiController::class, 'index'])->name('absensi.index');
    Route::post('/absensi',       [AbsensiController::class, 'store'])->name('absensi.store');
    Route::get('/absensi/rekap',  [AbsensiController::class, 'rekap'])->name('absensi.rekap');

    // ─── Nilai (placeholder) ──────────────────────────────────
    Route::post('/nilai', function () {
        return back()->with('success', 'Nilai berhasil disimpan!');
    })->name('nilai.store');

    // ─── Admin Dashboard ──────────────────────────────────────
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

//Nilai
Route::get('/nilai', [NilaiController::class, 'index']);
Route::post('/nilai/store', [NilaiController::class, 'store']);