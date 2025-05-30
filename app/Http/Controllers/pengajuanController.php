<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class pengajuanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->isAdmin()) {
            $pengaduan = Pengaduan::with(['kategori', 'status', 'user'])
                            ->latest()
                            ->filter(request(['search', 'status', 'kategori']))
                            ->paginate(10);
        } 
        else {
            $pengaduan = Pengaduan::where('user_id', Auth::id())
                            ->with(['kategori', 'status'])
                            ->latest()
                            ->filter(request(['search', 'status', 'kategori']))
                            ->paginate(10);
        }
        return view('pengaduan.index', [
            'pengaduan' => $pengaduan,
            'kategories' => KategoriPengaduan::all(),
            'statuses' => StatusPengaduan::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::user()->isMahasiswa()) {
            abort(403);
        }

        return view('pengaduan.create', [
            'kategories' => KategoriPengaduan::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|min:10|max:100',
            'deskripsi' => 'required|min:20',
            'kategori_id' => 'required|exists:kategori_pengaduan,id',
            'lokasi' => 'required|max:50',
            'urgensi' => 'required|in:rendah,sedang,tinggi,kritis',
            'bukti' => 'required|file|mimes:jpg,png,jpeg,pdf|max:5120', // 5MB
        ]);

        $path = $request->file('bukti')->store('bukti_pengaduan');

        Pengaduan::create([
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'],
            'kategori_id' => $validated['kategori_id'],
            'lokasi' => $validated['lokasi'],
            'urgensi' => $validated['urgensi'],
            'bukti_path' => $path,
            'user_id' => Auth::id(),
            'status_id' => 1 // Status default: Menunggu
        ]);

        return redirect()->route('pengaduan.index')
                         ->with('success', 'Pengaduan berhasil diajukan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (Auth::user()->isMahasiswa() && $pengaduan->user_id != Auth::id()) {
            abort(403);
        }

        return view('pengaduan.show', [
            'pengaduan' => $pengaduan->load(['kategori', 'status', 'user'])
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (Auth::user()->isMahasiswa() && $pengaduan->user_id != Auth::id()) {
            abort(403);
        }

        // Hanya pengaduan dengan status "Menunggu" yang bisa diedit
        if ($pengaduan->status_id != 1 && Auth::user()->isMahasiswa()) {
            return redirect()->back()
                             ->with('error', 'Hanya pengaduan berstatus Menunggu yang bisa diedit');
        }

        return view('pengaduan.edit', [
            'pengaduan' => $pengaduan,
            'kategories' => KategoriPengaduan::all(),
            'statuses' => Auth::user()->isAdmin() ? StatusPengaduan::all() : null
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (Auth::user()->isMahasiswa()) {
            $validated = $request->validate([
                'judul' => 'required|min:10|max:100',
                'deskripsi' => 'required|min:20',
                'kategori_id' => 'required|exists:kategori_pengaduan,id',
                'lokasi' => 'required|max:50',
                'urgensi' => 'required|in:rendah,sedang,tinggi,kritis',
                'bukti' => 'nullable|file|mimes:jpg,png,jpeg,pdf|max:5120',
            ]);
        }

        else {
            $validated = $request->validate([
                'status_id' => 'required|exists:status_pengaduan,id',
                'catatan_admin' => 'nullable|max:255'
            ]);
        }

        if ($request->hasFile('bukti')) {
            // Hapus file lama
            Storage::delete($pengaduan->bukti_path);
            
            // Simpan file baru
            $validated['bukti_path'] = $request->file('bukti')->store('bukti_pengaduan');
        }

        $pengaduan->update($validated);

        return redirect()->route('pengaduan.show', $pengaduan->id)
                         ->with('success', 'Pengaduan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (Auth::user()->isMahasiswa() && $pengaduan->user_id != Auth::id()) {
            abort(403);
        }

        if ($pengaduan->status_id != 1 && Auth::user()->isMahasiswa()) {
            return redirect()->back()
                             ->with('error', 'Hanya pengaduan berstatus Menunggu yang bisa dihapus');
        }

        if ($pengaduan->bukti_path) {
            Storage::delete($pengaduan->bukti_path);
        }

        $pengaduan->delete();

        return redirect()->route('pengaduan.index')
                         ->with('success', 'Pengaduan berhasil dihapus!');

    }

    public function apiIndex()
    {
        $pengaduan = Pengaduan::with(['kategori', 'status', 'user'])
                        ->latest()
                        ->filter(request(['search', 'status', 'kategori']))
                        ->paginate(10);

        return response()->json($pengaduan);
    }
}
