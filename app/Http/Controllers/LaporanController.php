<?php

use App\Models\LaporanPengaduan;
use Illuminate\Http\Request;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanPengaduanExport;

class LaporanController extends Controller
{
    public function index() {
        return response()->json(LaporanPengaduan::with('pengaduan')->get());
    }

    public function filterByDate(Request $request) {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date'
        ]);

        $laporan = LaporanPengaduan::whereBetween('tanggal_laporan', [
            $request->start_date, $request->end_date
        ])->get();

        return response()->json($laporan);
    }

    public function filterByKategori($kategori) {
        return response()->json(LaporanPengaduan::where('kategori', $kategori)->get());
    }

    public function exportPDF() {
        $data = LaporanPengaduan::all();
        $pdf = PDF::loadView('laporan.pdf', compact('data'));
        return $pdf->download('laporan_pengaduan.pdf');
    }

    public function exportExcel() {
        return Excel::download(new LaporanPengaduanExport, 'laporan_pengaduan.xlsx');
    }
}
