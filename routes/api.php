<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StatusPengaduanApiController;
use App\Http\Controllers\StatusPengaduanController;
<<<<<<< HEAD
use App\Http\Controllers\LaporanController;

=======
>>>>>>> 8e38a2b0ea25aaa66776c5c522bce782639ed6e1

Route::get('/status/pengaduan', [StatusPengaduanApiController::class, 'index']);
Route::post('/status/pengaduan', [StatusPengaduanController::class, 'store']);

<<<<<<< HEAD
Route::prefix('laporan')->group(function () {
    Route::get('/pengaduan', [LaporanController::class, 'index']);
    Route::get('/pengaduan/kategori/{kategori}', [LaporanController::class, 'filterByKategori']);
    Route::get('/pengaduan/filter', [LaporanController::class, 'filterByDate']);
    Route::get('/pengaduan/export/pdf', [LaporanController::class, 'exportPDF']);
    Route::get('/pengaduan/export/excel', [LaporanController::class, 'exportExcel']);
});
=======

>>>>>>> 8e38a2b0ea25aaa66776c5c522bce782639ed6e1
