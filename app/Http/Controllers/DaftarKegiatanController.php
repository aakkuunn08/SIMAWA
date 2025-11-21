<?php

namespace App\Http\Controllers;

use App\Models\DaftarKegiatan;

class DaftarKegiatanController extends Controller
{
    public function index()
    {
        $kegiatan = DaftarKegiatan::all(); // ambil data dari DB
        return view('kegiatan.index', compact('kegiatan')); // kirim ke view
    }
}
