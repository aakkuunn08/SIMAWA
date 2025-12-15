<?php

namespace App\Http\Controllers;

use App\Models\DaftarKegiatan;
use App\Models\Lpj; // Tambahkan ini
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // Tambahkan ini
use Carbon\Carbon; // Tambahkan ini

class DaftarKegiatanController extends Controller
{
    public function index()
    {
        $kegiatan = DaftarKegiatan::all();
        return view('kegiatan.index', compact('kegiatan'));
    }

    /**
     * Get events for calendar display
     */
    public function getEvents()
    {
        // Mengambil data beserta relasi lpj (opsional, tapi bagus untuk performa)
        $kegiatan = DaftarKegiatan::all();
        $events = [];
        
        foreach ($kegiatan as $k) {
            $date = $k->tanggal_kegiatan;
            if (!isset($events[$date])) {
                $events[$date] = [];
            }
            
            // Kita bisa kirim data lpj juga di sini jika perlu ditampilkan di kalender langsung
            $events[$date][] = [
                'id' => $k->id_kegiatan,
                'nama' => $k->nama_kegiatan,
                'tempat' => $k->tempat,
                'waktu_mulai' => $k->waktu_mulai,
                'waktu_selesai' => $k->waktu_selesai,
                // 'has_lpj' => $k->lpj ? true : false // Contoh jika butuh indikator di kalender
            ];
        }
        
        return response()->json($events);
    }

    /**
     * Store a new activity
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kegiatan' => 'required|string|max:200',
            'tanggal_kegiatan' => 'required|date',
            'tempat' => 'required|string|max:200',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
        ]);

        $userId = Auth::user()->id;

        $kegiatan = DaftarKegiatan::create([
            'user_id' => $userId,
            'nama_kegiatan' => $validated['nama_kegiatan'],
            'tanggal_kegiatan' => $validated['tanggal_kegiatan'],
            'tempat' => $validated['tempat'],
            'waktu_mulai' => $validated['waktu_mulai'],
            'waktu_selesai' => $validated['waktu_selesai'],
            'status_kegiatan' => 'scheduled',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kegiatan berhasil ditambahkan',
            'data' => $kegiatan
        ]);
    }

    /**
     * Get single activity details
     * UPDATE: Menambahkan relasi LPJ
     */
    public function show($id)
    {
        // Tambahkan with('lpj') agar data file ikut terkirim ke Javascript
        // Pastikan di Model DaftarKegiatan sudah ada fungsi public function lpj()
        $kegiatan = DaftarKegiatan::with('lpj')->findOrFail($id);
        
        return response()->json($kegiatan);
    }

    /**
     * Update an activity
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_kegiatan' => 'required|string|max:200',
            'tanggal_kegiatan' => 'required|date',
            'tempat' => 'required|string|max:200',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
        ]);

        $kegiatan = DaftarKegiatan::findOrFail($id);
        $kegiatan->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Kegiatan berhasil diupdate',
            'data' => $kegiatan
        ]);
    }

    /**
     * Delete an activity
     */
    public function destroy($id)
    {
        $kegiatan = DaftarKegiatan::findOrFail($id);
        
        // Opsional: Hapus file LPJ fisik jika kegiatan dihapus
        if ($kegiatan->lpj && $kegiatan->lpj->file_lpj) {
            Storage::disk('public')->delete($kegiatan->lpj->file_lpj);
        }
        
        $kegiatan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kegiatan berhasil dihapus'
        ]);
    }

    /**
     * BARU: Handle Upload LPJ
     */
    public function uploadLpj(Request $request, $id)
    {
        $request->validate([
            'file_lpj' => 'required|mimes:pdf,doc,docx|max:5120', // Maks 5MB
        ]);

        // Cari kegiatan berdasarkan ID
        $kegiatan = DaftarKegiatan::findOrFail($id);

        if ($request->hasFile('file_lpj')) {
            $file = $request->file('file_lpj');
            
            // Generate nama file unik: waktu_namaoriginal
            $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            
            // Simpan ke folder: storage/app/public/lpj_files
            $path = $file->storeAs('lpj_files', $filename, 'public');

            // Simpan/Update data ke tabel LPJ
            // Menggunakan updateOrCreate agar jika file sudah ada, dia menimpa record lama
            Lpj::updateOrCreate(
                ['id_kegiatan' => $kegiatan->id_kegiatan], // Kriteria pencarian (Foreign Key)
                [
                    'file_lpj' => $path,
                    'tanggal_upload' => Carbon::now(),
                    'status_lpj' => 'Menunggu Review' // Status default
                ]
            );

            return response()->json([
                'success' => true, 
                'message' => 'LPJ berhasil diupload!',
                'path' => $path
            ]);
        }

        return response()->json([
            'success' => false, 
            'message' => 'File tidak ditemukan'
        ], 400);
    }
}