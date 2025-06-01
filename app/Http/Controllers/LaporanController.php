<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;

class LaporanController extends Controller
{
public function index(Request $request)
{
    $query = \App\Models\Pengaduan::query();

    if ($request->filled('start_date') && $request->filled('end_date')) {
        $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
    }

    $rekap = $query->selectRaw('kategori, status, COUNT(*) as jumlah')
                   ->groupBy('kategori', 'status')
                   ->get();

    return view('laporan.index', compact('rekap'));
}

}
