<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StatusPengaduan;

class StatusPengaduanApiController extends Controller
{
    public function index()
    {
        return response()->json(StatusPengaduan::all());
    }
}
