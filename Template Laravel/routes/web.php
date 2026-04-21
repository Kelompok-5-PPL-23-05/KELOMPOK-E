<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AdminController;

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

    // ─── Admin Panel ──────────────────────────────────────────
    Route::prefix('admin')->name('admin.')->group(function () {
        // Dashboard admin
        Route::get('/',          [AdminController::class, 'dashboard'])->name('dashboard');

        // Manajemen Siswa
        Route::get('/siswa',            [AdminController::class, 'siswaIndex'])->name('siswa');
        Route::post('/siswa',           [AdminController::class, 'siswaStore'])->name('siswa.store');
        Route::put('/siswa/{id}',       [AdminController::class, 'siswaUpdate'])->name('siswa.update');
        Route::delete('/siswa/{id}',    [AdminController::class, 'siswaDestroy'])->name('siswa.destroy');

        // Manajemen Kelas
        Route::get('/kelas',            [AdminController::class, 'kelasIndex'])->name('kelas');
        Route::post('/kelas',           [AdminController::class, 'kelasStore'])->name('kelas.store');
        Route::put('/kelas/{id}',       [AdminController::class, 'kelasUpdate'])->name('kelas.update');
        Route::delete('/kelas/{id}',    [AdminController::class, 'kelasDestroy'])->name('kelas.destroy');

        // Manajemen Mata Pelajaran
        Route::get('/mapel',            [AdminController::class, 'mapelIndex'])->name('mapel');
        Route::post('/mapel',           [AdminController::class, 'mapelStore'])->name('mapel.store');
        Route::put('/mapel/{id}',       [AdminController::class, 'mapelUpdate'])->name('mapel.update');
        Route::delete('/mapel/{id}',    [AdminController::class, 'mapelDestroy'])->name('mapel.destroy');

        // Manajemen Guru
        Route::get('/guru',             [AdminController::class, 'guruIndex'])->name('guru');
        Route::post('/guru',            [AdminController::class, 'guruStore'])->name('guru.store');
        Route::delete('/guru/{id}',     [AdminController::class, 'guruDestroy'])->name('guru.destroy');
    });
    // ──────────────────────────────────────────────────────────

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
