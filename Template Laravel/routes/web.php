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

    Route::get('/admin/siswa', [AdminController::class, 'siswaIndex'])->name('admin.siswa.index');
    Route::post('/admin/siswa', [AdminController::class, 'siswaStore'])->name('admin.siswa.store');
    Route::post('/admin/siswa/import', [AdminController::class, 'siswaImport'])->name('admin.siswa.import');
    Route::post('/admin/siswa/import-preview', [AdminController::class, 'siswaImportPreview'])->name('admin.siswa.import.preview');
    Route::post('/admin/siswa/import-save', [AdminController::class, 'siswaImportSave'])->name('admin.siswa.import.save');
    Route::delete('/admin/siswa/{id}', [AdminController::class, 'siswaDestroy'])->name('admin.siswa.destroy');

    Route::get('/admin/lembaga', [AdminController::class, 'lembagaIndex'])->name('admin.lembaga.index');
    Route::post('/admin/lembaga/import-preview', [AdminController::class, 'lembagaImportPreview'])->name('admin.lembaga.import.preview');
    Route::post('/admin/lembaga/import-save', [AdminController::class, 'lembagaImportSave'])->name('admin.lembaga.import.save');

    Route::get('/admin/kelas', [AdminController::class, 'kelasIndex'])->name('admin.kelas.index');
    Route::post('/admin/kelas', [AdminController::class, 'kelasStore'])->name('admin.kelas.store');
    
    Route::delete('/admin/kelas/{id}', [AdminController::class, 'kelasDestroy'])->name('admin.kelas.destroy');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
