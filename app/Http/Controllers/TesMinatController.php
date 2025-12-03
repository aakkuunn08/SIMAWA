<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Soal;
use App\Models\TesMinat;
use App\Models\Ormawa;

/**
 * Controller untuk mengelola Tes Minat UKM
 * Menangani form biodata, kuesioner, dan rekomendasi UKM
 */
class TesMinatController extends Controller
{
    /**
     * Menampilkan halaman tes minat
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Ambil semua soal dari database untuk ditampilkan di kuesioner
        $soals = Soal::all();
        
        return view('tesminat', compact('soals'));
    }

    /**
     * Menampilkan halaman hasil tes minat untuk admin BEM
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function showResults(Request $request)
    {
        // Ambil query search jika ada
        $search = $request->get('search', '');
        
        // Query tes minat
        $query = TesMinat::orderBy('created_at', 'desc');
        
        // Filter berdasarkan search (nama atau NIM)
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'LIKE', "%{$search}%")
                  ->orWhere('nim', 'LIKE', "%{$search}%");
            });
        }
        
        $tesMinats = $query->get();
        
        return view('tesminatbem', compact('tesMinats', 'search'));
    }

    /**
     * Memproses submit form tes minat dan memberikan rekomendasi UKM
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function submit(Request $request)
    {
        // Validasi input biodata mahasiswa
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nim' => 'required|numeric',
            'program_studi' => 'required|string|max:255',
            'angkatan' => 'required|numeric',
        ]);

        // Ambil jawaban dari request
        $jawaban = [
            'q1' => (int) $request->input('q1', 0),
            'q2' => (int) $request->input('q2', 0),
            'q3' => (int) $request->input('q3', 0),
            'q4' => (int) $request->input('q4', 0),
            'q5' => (int) $request->input('q5', 0),
            'q6' => (int) $request->input('q6', 0),
        ];

        // Inisialisasi score untuk setiap UKM
        $scores = [
            'HERO' => 0,      // Robotika/Hardware
            'HCC' => 0,       // Pemrograman/Software
            'MPM' => 0,       // Agama/Rohani
            'Seni' => 0,      // Seni/Budaya
            'Olahraga' => 0,  // Olahraga
        ];

        // Perhitungan score berdasarkan jawaban
        // Q1: Sains & Teknologi (umum) → HERO & HCC (bobot kecil karena umum)
        $scores['HERO'] += $jawaban['q1'] * 1;
        $scores['HCC'] += $jawaban['q1'] * 1;

        // Q2: Olahraga & Adrenalin → Olahraga (bobot penuh)
        $scores['Olahraga'] += $jawaban['q2'] * 2;

        // Q3: Seni & Ekspresi → Seni (bobot penuh)
        $scores['Seni'] += $jawaban['q3'] * 2;

        // Q4: Berkumpul & Kelompok → MPM (bobot penuh)
        $scores['MPM'] += $jawaban['q4'] * 2;

        // Q5: Robot & Hardware → HERO (bobot tinggi karena spesifik)
        $scores['HERO'] += $jawaban['q5'] * 3;

        // Q6: Coding & Aplikasi → HCC (bobot tinggi karena spesifik)
        $scores['HCC'] += $jawaban['q6'] * 3;

        // Cari UKM dengan score tertinggi
        arsort($scores); // Sort descending berdasarkan nilai
        $topUkmName = array_key_first($scores);
        $topScore = $scores[$topUkmName];

        // Ambil data UKM dari database berdasarkan nama
        $rekomendasi = Ormawa::where('tipe', 'ukm')
            ->where('nama', 'LIKE', "%{$topUkmName}%")
            ->first();

        // Jika tidak ditemukan, ambil UKM pertama yang tersedia
        if (!$rekomendasi) {
            $rekomendasi = Ormawa::where('tipe', 'ukm')->first();
        }

        // Pastikan ada UKM yang tersedia
        if (!$rekomendasi) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada UKM yang tersedia'
            ], 404);
        }

        // Simpan hasil tes ke database (1 record untuk keseluruhan tes)
        TesMinat::create([
            'user_id' => auth()->id() ?? null, // Jika user login, simpan user_id
            'nama_lengkap' => $validated['nama_lengkap'],
            'nim' => $validated['nim'],
            'program_studi' => $validated['program_studi'],
            'angkatan' => $validated['angkatan'],
            'id_soal' => null, // Tidak perlu id_soal karena ini hasil keseluruhan
            'id_jawaban' => null,
            'hasil_rekomendasi' => $rekomendasi->nama . ' (Score: ' . round($topScore, 2) . ')',
        ]);

        // Return response JSON dengan data rekomendasi
        return response()->json([
            'success' => true,
            'rekomendasi' => [
                'nama' => $rekomendasi->nama,
                'logo' => asset($rekomendasi->logo),
                'deskripsi' => $rekomendasi->deskripsi ?? 'Unit Kegiatan Mahasiswa yang sesuai dengan minat dan bakat Anda.',
                'score' => $topScore,
                'all_scores' => $scores, // Untuk debugging - lihat semua score
            ]
        ]);
    }
}
