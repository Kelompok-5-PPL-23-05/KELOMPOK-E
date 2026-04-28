<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RaporController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\SiswaController;

Route::post('/rapor/generate',         [RaporController::class, 'generate']);
Route::get('/rapor/{id_siswa}',        [RaporController::class, 'show']);
Route::get('/rapor/{id_siswa}/export', [RaporController::class, 'exportPdf']);

Route::get('/kelas', [KelasController::class, 'index']);
Route::get('/siswa/{id_kelas}',        [SiswaController::class, 'getByKelas']);
Route::put('/siswa/{id_siswa}',        [SiswaController::class, 'update']);
Route::delete('/siswa/{id_siswa}',     [SiswaController::class, 'destroy']);