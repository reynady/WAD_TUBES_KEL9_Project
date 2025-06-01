<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StatusPengaduanApiController;
use App\Http\Controllers\StatusPengaduanController;

Route::get('/status/pengaduan', [StatusPengaduanApiController::class, 'index']);
Route::post('/status/pengaduan', [StatusPengaduanController::class, 'store']);


