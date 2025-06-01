<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;

class HomeController extends Controller
{
    public function index()
    {
        $pengaduan = Pengaduan::latest()->paginate(8);
        return view('home', compact('pengaduan'));
    }
}
