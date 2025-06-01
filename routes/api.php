<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StatusPengaduanApiController;
use App\Http\Controllers\StatusPengaduanController;
use App\Http\Controllers\LaporanController;


Route::get('/status/pengaduan', [StatusPengaduanApiController::class, 'index']);
Route::post('/status/pengaduan', [StatusPengaduanController::class, 'store']);

Route::prefix('laporan')->group(function () {
    Route::get('/pengaduan', [LaporanController::class, 'index']);
    Route::get('/pengaduan/kategori/{kategori}', [LaporanController::class, 'filterByKategori']);
    Route::get('/pengaduan/filter', [LaporanController::class, 'filterByDate']);
    Route::get('/pengaduan/export/pdf', [LaporanController::class, 'exportPDF']);
    Route::get('/pengaduan/export/excel', [LaporanController::class, 'exportExcel']);
});
