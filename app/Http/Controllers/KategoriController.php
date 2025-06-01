<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index() {
        return response()->json(Kategori::all());
    }

    public function show($id) {
        $kategori = Kategori::findOrFail($id);
        return response()->json($kategori);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|unique:kategoris,nama|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $kategori = Kategori::create($validator->validated());
        return response()->json($kategori, 201);
    }

    public function update(Request $request, $id) {
        $kategori = Kategori::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255|unique:kategoris,nama,' . $id,
            'deskripsi' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $kategori->update($validator->validated());
        return response()->json($kategori);
    }

    public function destroy($id) {
        $kategori = Kategori::findOrFail($id);

        
        if (method_exists($kategori, 'pengaduan') && $kategori->pengaduan()->exists()) {
            return response()->json(['error' => 'Kategori sedang digunakan dan tidak dapat dihapus.'], 400);
        }

        $kategori->delete();
        return response()->json(['message' => 'Kategori berhasil dihapus.']);
    }
}
