<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StatusPengaduanApiController;

Route::get('/status/pengaduan', [StatusPengaduanApiController::class, 'index']);
