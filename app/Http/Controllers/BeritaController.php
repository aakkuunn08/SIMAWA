<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    /**
     * Tampilkan daftar berita (untuk Mahasiswa/Umum)
     */
    public function index()
    {
        $beritas = Berita::where('published', true)->orderBy('tanggal_publikasi', 'desc')->get();
        return view('berita.index', compact('beritas')); // Sesuaikan dengan nama view kamu
    }

    /**
     * Tampilkan form untuk membuat berita baru
     */
    public function create()
    {
        return view('admin.berita.form', ['berita' => null, 'isEdit' => false]);
    }

    /**
     * Simpan berita baru (dengan upload gambar)
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // AMBIL ATTRIBUT 'id' LANGSUNG DARI OBJECT USER
        // Ini cara paling ampuh jika auth()->id() bermasalah
        $userId = auth()->user()->id; 

        $data = [
            'user_id' => $userId, 
            'judul_berita' => $request->judul,
            'konten' => $request->konten,
            'tanggal_publikasi' => now(),
            'published' => true,
        ];

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        \App\Models\Berita::create($data);

        return redirect()->route('dashboard')->with('success', 'Berita berhasil diterbitkan!');
    }

    /**
     * Fungsi EDIT: Inilah yang membuat tombol edit bisa diklik
     */
    public function edit($id)
    {
        $berita = Berita::findOrFail($id);
        
        // Proteksi Policy
        $this->authorize('update', $berita);

        // Mengembalikan data JSON agar bisa ditangkap oleh Modal di Dashboard
        return response()->json($berita);
    }

    /**
     * Fungsi UPDATE: Untuk menyimpan perubahan edit dan ganti gambar
     */
    public function update(Request $request, $id)
    {
        $berita = Berita::findOrFail($id);
        $this->authorize('update', $berita);

        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Sinkronkan nama input form dengan kolom database
        $data = [
            'judul_berita' => $request->judul, 
            'konten' => $request->konten,
            'published' => $request->has('published') ? true : $berita->published,
        ];

        if ($request->hasFile('gambar')) {
            if ($berita->gambar) {
                Storage::disk('public')->delete($berita->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        $berita->update($data);

        // Redirect ke dashboard agar tidak muncul layar putih JSON
        return redirect()->route('dashboard')->with('success', 'Berita berhasil diperbarui!');
    }

    public function show($id)
    {
        $berita = Berita::with('user')->findOrFail($id);
        return view('berita.show', compact('berita')); // Mengarah ke resources/views/berita/show.blade.php
    }

    public function destroy($id)
    {
        $berita = Berita::findOrFail($id);
        if ($berita->gambar) {
            Storage::disk('public')->delete($berita->gambar);
        }
        $berita->delete();
        return redirect()->back()->with('success', 'Berita berhasil dihapus');
    }

    // Untuk API jika masih dibutuhkan
    public function getData() {
        return Berita::where('published', true)->get();
    }
}