<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StatusPengaduan;

class StatusPengaduanApiController extends Controller
{
    public function index()
    {
        $data = StatusPengaduan::all();

        return response()->json([
            'status' => true,
            'message' => 'Data status pengaduan berhasil diambil',
            'data' => $data
        ]);
    }
}
