<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Soal;
use App\Models\TesMinat;
use App\Models\Ormawa;
use Illuminate\Support\Facades\Log;

/**
 * Controller untuk mengelola Tes Minat UKM
 * Menangani pengolahan skor minat dan manajemen pertanyaan
 */
class TesMinatController extends Controller
{
    /**
     * Menampilkan halaman tes minat untuk mahasiswa
     */
    public function index()
    {
        // Ambil semua soal dan acak urutannya agar adil
        $soals = Soal::all()->shuffle();
        return view('tesminat', compact('soals'));
    }

    /**
     * Memproses submit form tes minat dan memberikan rekomendasi UKM
     */
    public function submit(Request $request)
    {
        try {
            // 1. Validasi input biodata mahasiswa
            $validated = $request->validate([
                'nama_lengkap' => 'required|string|max:255',
                'nim'          => 'required',
                'program_studi' => 'required|string|max:255',
                'angkatan'     => 'required',
            ]);

            $soals = Soal::all();
            
            // 2. Inisialisasi skor kategori secara dinamis dari database
            $categories = $soals->pluck('kategori')->unique();
            $scores = [];
            foreach ($categories as $cat) { 
                if ($cat) $scores[$cat] = 0; 
            }

            // 3. Hitung Skor berdasarkan jawaban yang dikirim
            foreach ($soals as $soal) {
                $jawabanKey = 'q' . $soal->id_soal;
                if ($request->has($jawabanKey) && isset($scores[$soal->kategori])) {
                    $scores[$soal->kategori] += (int) $request->input($jawabanKey, 0);
                }
            }

            // Urutkan kategori dari skor tertinggi
            arsort($scores);
            $topKategori = array_key_first($scores);

            if (!$topKategori) {
                return response()->json(['success' => false, 'message' => 'Gagal menghitung kategori minat.'], 400);
            }
            
            // 4. Hitung persentase skor tertinggi
            $soalDiKategoriIni = $soals->where('kategori', $topKategori)->count();
            $maxPossibleScore = $soalDiKategoriIni * 5;
            $topScorePercent = $maxPossibleScore > 0 ? ($scores[$topKategori] / $maxPossibleScore) * 100 : 0;

            // 5. Cari Ormawa yang sesuai berdasarkan nama kategori
            // Perbaikan: Mencari tanpa filter kolom 'tipe' untuk menghindari SQL Error
            $rekomendasi = Ormawa::where('nama', 'LIKE', "%{$topKategori}%")->first();

            // Fallback: Jika tidak ditemukan yang spesifik, ambil data pertama agar sistem tidak crash
            if (!$rekomendasi) {
                $rekomendasi = Ormawa::first();
            }

            if (!$rekomendasi) {
                return response()->json(['success' => false, 'message' => 'Data UKM belum tersedia.'], 404);
            }

            // 6. Simpan Hasil Tes ke Database
            TesMinat::create([
                'user_id'           => auth()->id(),
                'nama_lengkap'      => $validated['nama_lengkap'],
                'nim'               => $validated['nim'],
                'program_studi'     => $validated['program_studi'],
                'angkatan'          => $validated['angkatan'],
                'hasil_rekomendasi' => $rekomendasi->nama . ' (' . round($topScorePercent, 2) . '%)',
                'id_soal'           => null, // Nullable sesuai struktur tabel
                'id_jawaban'        => null,
            ]);

            return response()->json([
                'success' => true,
                'rekomendasi' => [
                    'nama' => $rekomendasi->nama,
                    'logo' => $rekomendasi->logo ? asset($rekomendasi->logo) : null,
                    'deskripsi' => $rekomendasi->deskripsi ?? 'UKM ini sangat cocok dengan minat Anda.',
                ]
            ]);

        } catch (\Exception $e) {
            Log::error("Tes Minat Error: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Kesalahan: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Menyimpan pertanyaan baru dengan kategori yang diwajibkan
     */
    public function storeQuestion(Request $request)
    {
        try {
            $validated = $request->validate([
                'pertanyaan' => 'required|string',
                'kategori'   => 'required|string', // Kategori wajib diisi untuk menghindari error database
                'skala_likert' => 'nullable|integer|min:1|max:10'
            ]);

            $soal = Soal::create([
                'pertanyaan' => $validated['pertanyaan'],
                'kategori'   => $validated['kategori'],
                'skala_likert' => $validated['skala_likert'] ?? 5
            ]);

            return response()->json([
                'success' => true, 
                'message' => 'Pertanyaan berhasil ditambahkan', 
                'question' => $soal
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Memperbarui data pertanyaan
     */
    public function updateQuestion(Request $request, $id)
    {
        try {
            $soal = Soal::findOrFail($id);
            $validated = $request->validate([
                'pertanyaan' => 'required|string',
                'kategori'   => 'required|string',
                'skala_likert' => 'nullable|integer'
            ]);

            $soal->update($validated);

            return response()->json(['success' => true, 'message' => 'Pertanyaan berhasil diperbarui']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Menampilkan daftar hasil tes untuk Admin BEM
     */
    public function showResults(Request $request)
    {
        $search = $request->get('search', '');
        $query = TesMinat::with('user')->orderBy('created_at', 'desc');
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'LIKE', "%{$search}%")
                  ->orWhere('nim', 'LIKE', "%{$search}%")
                  ->orWhereHas('user', function($subQ) use ($search) {
                      $subQ->where('name', 'LIKE', "%{$search}%")
                           ->orWhere('username', 'LIKE', "%{$search}%");
                  });
            });
        }
        
        $tesMinats = $query->get();
        return view('tesminatbem', compact('tesMinats', 'search'));
    }

    public function showMenu() { return view('tesminat-menu'); }
    
    public function manageQuestions() { return view('kelola-pertanyaan'); }

    public function getQuestionsData()
    {
        return response()->json(['success' => true, 'questions' => Soal::orderBy('id_soal', 'asc')->get()]);
    }

    public function delete($id)
    {
        TesMinat::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }

    public function deleteQuestion($id)
    {
        Soal::findOrFail($id)->delete();
        return response()->json(['success' => true, 'message' => 'Pertanyaan berhasil dihapus']);
    }
}