<?php

namespace App\Http\Controllers;

use App\Models\StatusPengaduan;
use Illuminate\Http\Request;

class StatusPengaduanController extends Controller
{
    public function index()
    {
        $statusPengaduan = StatusPengaduan::all();
        return view('status-pengaduan.index', compact('statusPengaduan'));
    }

    public function create()
    {
        return view('status-pengaduan.create');
    }

    public function store(Request $request)
    {
        $request->validate(['nama' => 'required']);
        StatusPengaduan::create($request->all());
        return redirect()->route('status-pengaduan.index');
    }
    
    public function edit($id)
    {
        $statusPengaduan = StatusPengaduan::findOrFail($id);
        return view('status-pengaduan.edit', compact('statusPengaduan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(['nama' => 'required']);
        $status = StatusPengaduan::findOrFail($id);
        $status->update($request->all());
        return redirect()->route('status-pengaduan.index');
    }

    public function show($id)
    {
    $statusPengaduan = StatusPengaduan::findOrFail($id);
    return view('status-pengaduan.show', compact('statusPengaduan'));
    }


    public function destroy($id)
    {
        $status = StatusPengaduan::findOrFail($id);
        $status->delete();
        return redirect()->route('status-pengaduan.index');
    }
}