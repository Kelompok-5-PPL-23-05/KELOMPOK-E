<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RaporController;
use App\Http\Controllers\KelasController;

Route::post('/rapor/generate',         [RaporController::class, 'generate']);
Route::get('/rapor/{id_siswa}',        [RaporController::class, 'show']);
Route::get('/rapor/{id_siswa}/export', [RaporController::class, 'exportPdf']);

Route::get('/kelas', [KelasController::class, 'index']);