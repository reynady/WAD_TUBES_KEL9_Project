<?php

use App\Models\LaporanPengaduan;
use Illuminate\Http\Request;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanPengaduanExport;

class LaporanController extends Controller
{
<<<<<<< Updated upstream
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
=======
    public function index(Request $request)
    {
        $query = Pengaduan::query();

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        $rekap = $query->selectRaw('kategori, status, COUNT(*) as jumlah')
                       ->groupBy('kategori', 'status')
                       ->get();

        return view('laporan.index', compact('rekap'));
    }
>>>>>>> Stashed changes
}
