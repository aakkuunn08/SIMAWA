<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lpj; 
use App\Models\Kegiatan;

class LpjController extends Controller
{
    public function index(Request $request)
    {
        // 1. Mulai Query dari Model LPJ
        // Kita gunakan 'with' untuk mengambil data Kegiatan DAN User pemilik kegiatan sekaligus
        $query = Lpj::with(['kegiatan.user']); 

        // 2. Logika Search (Jika ada input cari)
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            
            // Cari LPJ berdasarkan Nama Kegiatan
            // "whereHas" artinya: Cari di dalam relasi 'kegiatan'
            $query->whereHas('kegiatan', function($q) use ($search) {
                $q->where('nama_kegiatan', 'like', '%' . $search . '%');
            });
        }

        // 3. Eksekusi (Urutkan terbaru & Paginasi)
        $semuaLpj = $query->latest()->paginate(10);

        // 4. Kirim ke View
        return view('lpj', compact('semuaLpj'));
    }
}