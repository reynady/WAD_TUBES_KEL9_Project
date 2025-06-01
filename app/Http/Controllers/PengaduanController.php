<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PengaduanController extends Controller
{
    public function index() {
        $pengaduan = Pengaduan::latest()->paginate(8);
        return view('admin.index', compact('pengaduan'));
    }

    public function create() {
        return view('pengaduan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|min:20',
            'kategori' => 'required|string',
            'lokasi' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $pengaduanData = $request->only(['title', 'content', 'kategori', 'lokasi']);
        $pengaduanData['status'] = 'Menunggu';
        $pengaduanData['user_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('pengaduan', 'public');
            $pengaduanData['image'] = $imagePath;
        }

        Pengaduan::create($pengaduanData);

        session()->flash('success', 'Pengaduan berhasil dibuat!');
        return redirect()->route('home');
    }

    public function edit(Pengaduan $pengaduan) {
        if ($pengaduan->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
        return view('pengaduan.edit', compact('pengaduan'));
    }

    public function update(Request $request, Pengaduan $pengaduan)
    {
        if ($pengaduan->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|min:20',
            'kategori' => 'required|string',
            'lokasi' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $pengaduanData = $request->only(['title', 'content', 'kategori', 'lokasi']);

        if ($request->hasFile('image')) {
            if ($pengaduan->image) {
                Storage::delete('public/' . $pengaduan->image);
            }

            $imagePath = $request->file('image')->store('pengaduan', 'public');
            $pengaduanData['image'] = $imagePath;
        }

        $pengaduan->update($pengaduanData);

        session()->flash('success', 'Pengaduan berhasil diperbarui!');
        return redirect()->route('home');
    }

    public function destroy(Pengaduan $pengaduan) {
        if ($pengaduan->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($pengaduan->image) {
            Storage::delete('public/' . $pengaduan->image);
        }

        $pengaduan->delete();
        session()->flash('success', 'Pengaduan berhasil dihapus!');
        return redirect()->route('home');
    }

    public function show($id)
    {
        $pengaduan = Pengaduan::with(['comments.user', 'user'])->findOrFail($id);
        return view('pengaduan.show', compact('pengaduan'));
    }
}
