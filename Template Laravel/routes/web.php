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
    
    // Pilih mata pelajaran yang diampu
    Route::get('/dashboard/select-mapel', [DashboardController::class, 'selectMapel'])->name('dashboard.select-mapel');
    Route::post('/dashboard/store-mapel', [DashboardController::class, 'storeMapel'])->name('dashboard.store-mapel');
    
    // Kelola siswa berdasarkan mata pelajaran
    Route::get('/dashboard/manage-students', [DashboardController::class, 'manageStudents'])->name('dashboard.manage-students');

    // Detail siswa
    Route::get('/dashboard/student/{id}', [DashboardController::class, 'studentDetail'])->name('dashboard.student-detail');

    // ─── Absensi ──────────────────────────────────────────────
    Route::get('/absensi',        [AbsensiController::class, 'index'])->name('absensi.index');
    Route::post('/absensi',       [AbsensiController::class, 'store'])->name('absensi.store');
    Route::get('/absensi/rekap',  [AbsensiController::class, 'rekap'])->name('absensi.rekap');

    // ─── Nilai ────────────────────────────────────────────────
    Route::get('/nilai',         [NilaiController::class, 'index'])->name('nilai.index');
    Route::post('/nilai/store',  [NilaiController::class, 'store'])->name('nilai.store');

    // ─── Admin Dashboard ──────────────────────────────────────
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        // ─── Admin Siswa ──────────────────────────────────────────
    Route::get('/admin/siswa',          [AdminController::class, 'siswa'])->name('admin.siswa');
    Route::post('/admin/siswa',         [AdminController::class, 'storeSiswa'])->name('admin.siswa.store');
    Route::delete('/admin/siswa/{id}',  [AdminController::class, 'destroySiswa'])->name('admin.siswa.destroy');

    // ─── Admin Lembaga ─────────────────────────────────────────
    Route::get('/admin/lembaga',       [AdminController::class, 'lembaga'])->name('admin.lembaga');
    Route::get('/admin/lembaga/edit',  [AdminController::class, 'lembagaEdit'])->name('admin.lembaga.edit');
    Route::post('/admin/lembaga/edit', [AdminController::class, 'updateLembaga'])->name('admin.lembaga.update');
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
