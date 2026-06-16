<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\RaporController;

// Redirect root ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// ─── Guru Dashboard ───────────────────────────────────────
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/input-nilai', [DashboardController::class, 'inputNilai'])->name('input-nilai');

// Pilih mata pelajaran yang diampu
Route::get('/dashboard/select-mapel', [DashboardController::class, 'selectMapel'])->name('dashboard.select-mapel');
Route::post('/dashboard/store-mapel', [DashboardController::class, 'storeMapel'])->name('dashboard.store-mapel');

// Kelola siswa berdasarkan mata pelajaran
Route::get('/dashboard/manage-students', [DashboardController::class, 'manageStudents'])->name('dashboard.manage-students');

// Detail siswa
Route::get('/dashboard/student/{id}', [DashboardController::class, 'studentDetail'])->name('dashboard.student-detail');

// ─── Absensi ──────────────────────────────────────────────
Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
Route::post('/absensi', [AbsensiController::class, 'store'])->name('absensi.store');
Route::get('/absensi/rekap', [AbsensiController::class, 'rekap'])->name('absensi.rekap');

// ─── Nilai ────────────────────────────────────────────────
Route::get('/nilai', [NilaiController::class, 'index'])->name('nilai.index');
Route::post('/nilai/store', [NilaiController::class, 'store'])->name('nilai.store');
Route::get('/nilai/akhir', [NilaiController::class, 'nilaiAkhir'])->name('nilai.akhir');
Route::get('/nilai/{nilai}/edit', [NilaiController::class, 'edit'])->name('nilai.edit');   // PPLE-58 & PPLE-59
Route::put('/nilai/{nilai}', [NilaiController::class, 'update'])->name('nilai.update');    // PPLE-60 & PPLE-61

// ─── Admin Dashboard ──────────────────────────────────────
Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');

// ─── Admin Siswa ──────────────────────────────────────────
Route::get('/admin/siswa', [AdminController::class, 'siswaIndex'])->name('admin.siswa.index');
Route::post('/admin/siswa', [AdminController::class, 'siswaStore'])->name('admin.siswa.store');
Route::post('/admin/siswa/import', [AdminController::class, 'siswaImport'])->name('admin.siswa.import');
Route::post('/admin/siswa/import-preview', [AdminController::class, 'siswaImportPreview'])->name('admin.siswa.import.preview');
Route::post('/admin/siswa/import-save', [AdminController::class, 'siswaImportSave'])->name('admin.siswa.import.save');
Route::put('/admin/siswa/{id}', [AdminController::class, 'siswaUpdate'])->name('admin.siswa.update');
Route::delete('/admin/siswa/{id}', [AdminController::class, 'siswaDestroy'])->name('admin.siswa.destroy');

Route::get('/admin/lembaga',       [AdminController::class, 'lembagaIndex'])->name('admin.lembaga.index');
Route::get('/admin/lembaga/edit',  [AdminController::class, 'lembagaEdit'])->name('admin.lembaga.edit');
Route::post('/admin/lembaga/edit', [AdminController::class, 'updateLembaga'])->name('admin.lembaga.update');
Route::post('/admin/lembaga/import-preview', [AdminController::class, 'lembagaImportPreview'])->name('admin.lembaga.import.preview');
Route::post('/admin/lembaga/import-save', [AdminController::class, 'lembagaImportSave'])->name('admin.lembaga.import.save');

// ─── Admin Kelas ───────────────────────────────────────────
Route::get('/admin/kelas', [AdminController::class, 'kelasIndex'])->name('admin.kelas.index');
Route::post('/admin/kelas', [AdminController::class, 'kelasStore'])->name('admin.kelas.store');
Route::delete('/admin/kelas/{id}', [AdminController::class, 'kelasDestroy'])->name('admin.kelas.destroy');

// ─── Admin Mata Pelajaran ──────────────────────────────────
Route::get('/admin/mapel', [AdminController::class, 'mapelIndex'])->name('admin.mapel.index');
Route::post('/admin/mapel', [AdminController::class, 'mapelStore'])->name('admin.mapel.store');
Route::put('/admin/mapel/{id}', [AdminController::class, 'mapelUpdate'])->name('admin.mapel.update');
Route::delete('/admin/mapel/{id}', [AdminController::class, 'mapelDestroy'])->name('admin.mapel.destroy');
Route::post('/admin/mapel/import-preview', [AdminController::class, 'mapelImportPreview'])->name('admin.mapel.import.preview');
Route::post('/admin/mapel/import-save', [AdminController::class, 'mapelImportSave'])->name('admin.mapel.import.save');

// ─── Rapor ────────────────────────────────────────────────
Route::get('/admin/rapor', [RaporController::class, 'index'])->name('rapor.index');
Route::get('/admin/rapor/arsip', [RaporController::class, 'arsip'])->name('rapor.arsip');
Route::post('/admin/rapor/generate/{id_siswa}', [RaporController::class, 'generatePdf'])->name('rapor.generate');
Route::get('/admin/rapor/download/{id_rapor}', [RaporController::class, 'download'])->name('rapor.download');

// ─── Rapor Cetak Langsung (Subtask 4) ──────────────────────
Route::get('/admin/rapor/cetak/{id_siswa}', [RaporController::class, 'cetakPdf'])->name('rapor.cetakPdf');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');