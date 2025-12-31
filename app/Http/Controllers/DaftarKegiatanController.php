<?php

namespace App\Http\Controllers;

use App\Models\DaftarKegiatan;
use App\Models\Lpj;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DaftarKegiatanController extends Controller
{
    public function index()
    {
        $kegiatan = DaftarKegiatan::all();
        return view('kegiatan.index', compact('kegiatan'));
    }

    // ==========================================
    // 1. GET EVENTS (UNTUK KALENDER)
    // ==========================================
    public function getEvents()
    {
        $kegiatan = DaftarKegiatan::all();
        $events = [];
        
        foreach ($kegiatan as $k) {
            $date = $k->tanggal_kegiatan;
            if (!isset($events[$date])) {
                $events[$date] = [];
            }
            
            $events[$date][] = [
                'id' => $k->id_kegiatan, // Pastikan ini sesuai nama kolom ID di database (id atau id_kegiatan)
                'nama' => $k->nama_kegiatan,
                'tempat' => $k->tempat,
                'waktu_mulai' => $k->waktu_mulai,
                'waktu_selesai' => $k->waktu_selesai,
            ];
        }
        
        return response()->json($events);
    }

    // ==========================================
    // 2. STORE (SIMPAN KEGIATAN)
    // ==========================================
    public function store(Request $request)
    {
        // 1. Cek Login
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Sesi habis'], 401);
        }

        // 2. Validasi
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'nama_kegiatan' => 'required|string|max:200',
            'tanggal_kegiatan' => 'required|date',
            'tempat' => 'required|string|max:200',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        try {
            // --- INI PERUBAHANNYA (JURUS ANTI RUSAK) ---
            // Kita ambil user yang lagi login
            $userLogin = Auth::user();
            
            // Kita pastikan kita ambil ANGKA ID-nya, bukan username-nya.
            // Biasanya kolom ID di database namanya 'id'.
            // Kalau model User.php ta' setting primaryKey='username', kita cari manual ID-nya:
            $userIdAngka = \App\Models\User::where('username', $userLogin->username)->value('id');

            // Jaga-jaga kalau cara di atas gagal (misal kolom username beda nama), pakai fallback:
            if (!$userIdAngka) {
                 // Ambil paksa kolom 'id' dari atribut asli
                 $userIdAngka = $userLogin->getAttributes()['id'] ?? null;
            }
            
            // Kalau masih null juga, berarti memang user ini tidak punya ID angka di database
            if (!$userIdAngka) {
                throw new \Exception("User ini tidak memiliki ID Angka di Database. Cek tabel users.");
            }

            // 3. Simpan
            $kegiatan = DaftarKegiatan::create([
                'user_id' => $userIdAngka, // <--- KITA MASUKKAN ANGKA DI SINI
                'nama_kegiatan' => $request->nama_kegiatan,
                'tanggal_kegiatan' => $request->tanggal_kegiatan,
                'tempat' => $request->tempat,
                'waktu_mulai' => $request->waktu_mulai,
                'waktu_selesai' => $request->waktu_selesai,
                'status_kegiatan' => 'scheduled',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Mantap! Kegiatan berhasil disimpan.',
                'data' => $kegiatan
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error Database: ' . $e->getMessage()
            ], 500);
        }
    }

    // ==========================================
    // 3. SHOW (DETAIL KEGIATAN) - SUDAH DIPERBAIKI
    // ==========================================
    public function show($id)
    {
        // PERBAIKAN: with(['lpj', 'user']) digabung dalam satu baris
        // Supaya data LPJ dan User terkirim dua-duanya
        $kegiatan = DaftarKegiatan::with(['lpj', 'user'])->findOrFail($id);
        
        return response()->json($kegiatan);
    }

    // ==========================================
    // 4. UPDATE KEGIATAN
    // ==========================================
    public function update(Request $request, $id)
    {
        $kegiatan = DaftarKegiatan::findOrFail($id);

        // --- CEK POLICY (SATPAM) ---
        // Kalau bukan pemilik & bukan BEM, stop di sini (Error 403)
        $this->authorize('update', $kegiatan); 

        $validated = $request->validate([
            'nama_kegiatan' => 'required|string|max:200',
            'tanggal_kegiatan' => 'required|date',
            'tempat' => 'required|string|max:200',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
        ]);

        $kegiatan->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Kegiatan berhasil diupdate',
            'data' => $kegiatan
        ]);
    }

    // ==========================================
    // 5. DELETE KEGIATAN
    // ==========================================
    public function destroy($id)
    {
        $kegiatan = DaftarKegiatan::with('lpj')->findOrFail($id);
        
        // --- CEK POLICY (SATPAM) ---
        $this->authorize('delete', $kegiatan); 

        // Hapus file LPJ fisik jika ada
        if ($kegiatan->lpj && $kegiatan->lpj->file_lpj) {
            Storage::delete('public/lpj_files/' . $kegiatan->lpj->file_lpj);
            $kegiatan->lpj()->delete();
        }
        
        $kegiatan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kegiatan berhasil dihapus'
        ]);
    }

    // ==========================================
    // 6. UPLOAD LPJ (DENGAN AES-128)
    // ==========================================
    public function uploadLpj(Request $request, $id)
    {
        $kegiatan = DaftarKegiatan::findOrFail($id);

        // --- CEK POLICY (SATPAM) ---
        // "Kalau kau tidak boleh edit kegiatan ini, kau juga tidak boleh upload LPJ-nya"
        $this->authorize('update', $kegiatan);

        $request->validate([
            'file_lpj' => 'required|file|mimes:pdf,doc,docx|max:5120',
        ]);
        
        if ($request->hasFile('file_lpj')) {
            $file = $request->file('file_lpj');
            
            // --- MULAI ENKRIPSI AES ---
            // 1. Ambil isi file asli
            $fileContent = file_get_contents($file->getRealPath());
            
            // 2. Siapkan Kunci & IV
            $key = env('AES_SECRET_KEY'); 
            
            $ivLen = openssl_cipher_iv_length('aes-128-cbc');
            $iv = openssl_random_pseudo_bytes($ivLen);
            
            // 3. Enkripsi
            $encryptedContent = openssl_encrypt($fileContent, 'aes-128-cbc', $key, 0, $iv);
            
            // 4. Gabungkan IV + Data (Base64)
            $dataToSave = base64_encode($iv . $encryptedContent);
            
            // 5. Buat nama file acak (biar aman)
            $filename = time() . '_' . Str::random(10) . '.enc';
            
            // 6. Simpan file terenkripsi
            Storage::put('public/lpj_files/' . $filename, $dataToSave);

            // --- SIMPAN KE DATABASE (Tabel Lpj) ---
            Lpj::updateOrCreate(
                ['id_kegiatan' => $kegiatan->id_kegiatan], // Kriteria
                [
                    'file_lpj' => $filename, // Nama file terenkripsi
                    'nama_lpj' => $file->getClientOriginalName(),
                    'tanggal_upload' => Carbon::now(),
                    'status_lpj' => 'Menunggu Review'
                ]
            );

            return response()->json([
                'success' => true, 
                'message' => 'LPJ Terenkripsi Berhasil Diupload!',
                'path' => $filename
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Gagal upload'], 400);
    }

    // ==========================================
    // 7. DOWNLOAD LPJ (SUPPORT DOCX/WORD)
    // ==========================================
    public function downloadLpj($id)
    {
        // Cari kegiatan beserta data LPJ-nya
        $kegiatan = DaftarKegiatan::with('lpj')->findOrFail($id);

        // Cek apakah file ada di storage
        if (!$kegiatan->lpj || !Storage::exists('public/lpj_files/' . $kegiatan->lpj->file_lpj)) {
            abort(404, 'File LPJ tidak ditemukan');
        }

        // 1. Ambil file terenkripsi dari storage
        $encryptedFile = Storage::get('public/lpj_files/' . $kegiatan->lpj->file_lpj);

        // --- MULAI DEKRIPSI AES ---
        $key = env('AES_SECRET_KEY'); 
        
        $data = base64_decode($encryptedFile);
        
        $ivLen = openssl_cipher_iv_length('aes-128-cbc');
        $iv = substr($data, 0, $ivLen);
        $encryptedContent = substr($data, $ivLen);

        $decryptedContent = openssl_decrypt($encryptedContent, 'aes-128-cbc', $key, 0, $iv);

        // --- INI PERBAIKANNYA (DETEKSI EKSTENSI ASLI) ---
        // Kita ambil nama file asli yang disimpan di database (misal: "laporan.docx")
        $namaAsli = $kegiatan->lpj->nama_lpj ?? 'dokumen.pdf'; // Fallback ke pdf kalau null
        
        // Ambil ekstensinya saja (misal: "docx")
        $extension = pathinfo($namaAsli, PATHINFO_EXTENSION);
        
        // Buat nama file download yang benar
        $downloadName = 'LPJ-' . Str::slug($kegiatan->nama_kegiatan) . '.' . $extension;

        // Download dengan nama yang sesuai aslinya
        return response()->streamDownload(function () use ($decryptedContent) {
            echo $decryptedContent;
        }, $downloadName);
    }

    // ==========================================
    // 8. VALIDASI LPJ (KHUSUS ADMIN BEM) - BARU
    // ==========================================
    public function validasiLpj(Request $request, $id)
    {
        // 1. Cek apakah user adalah ADMIN BEM?
        // Hanya BEM yang boleh terima/tolak revisi
        if (!Auth::user()->hasRole('adminbem')) {
            return response()->json(['message' => 'Anda bukan Admin BEM!'], 403);
        }

        $request->validate([
            'status' => 'required|in:revisi,diterima', // Hanya boleh 2 ini
            'catatan' => 'nullable|string'
        ]);

        $kegiatan = DaftarKegiatan::findOrFail($id);
        
        if (!$kegiatan->lpj) {
            return response()->json(['message' => 'LPJ belum diupload'], 404);
        }

        // Update status di tabel LPJ
        $kegiatan->lpj()->update([
            'status_lpj' => $request->status,
            'catatan_revisi' => $request->catatan // Pastikan kolom ini ada di database
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status LPJ berhasil diperbarui menjadi ' . $request->status
        ]);
    }
}