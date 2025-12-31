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
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->only(['judul', 'konten']);
        $data['user_id'] = Auth::id();
        $data['tanggal_publikasi'] = now();
        $data['published'] = true; // Default published

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        Berita::create($data);

        return response()->json(['success' => true, 'message' => 'Berita berhasil ditambahkan!']);
    }

    /**
     * Fungsi EDIT: Inilah yang membuat tombol edit bisa diklik
     */
    public function edit($id)
    {
        $berita = Berita::findOrFail($id);
        // Pastikan file view ini ada di: resources/views/admin/berita/form.blade.php
        return view('admin.berita.form', [
            'berita' => $berita,
            'isEdit' => true
        ]);
    }

    /**
     * Fungsi UPDATE: Untuk menyimpan perubahan edit dan ganti gambar
     */
    public function update(Request $request, $id)
    {
        $berita = Berita::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'url_sumber' => 'nullable|url',
        ]);

        $data = $request->all();
        $data['published'] = $request->has('published');

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($berita->gambar) {
                Storage::disk('public')->delete($berita->gambar);
            }
            // Simpan gambar baru
            $data['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        $berita->update($data);

        return redirect()->route('dashboard')->with('success', 'Berita berhasil diperbarui!');
    }

    public function show($id)
    {
        $berita = Berita::findOrFail($id);
        return view('berita.show', compact('berita'));
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