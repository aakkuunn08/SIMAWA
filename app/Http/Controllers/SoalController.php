<?php

namespace App\Http\Controllers;

use App\Models\Soal;
use Illuminate\Http\Request;

class SoalController extends Controller
{
    // TAMPILKAN SEMUA SOAL
    public function index()
    {
        $soal = Soal::all();
        return view('soal.index', compact('soal'));
    }

    // FORM TAMBAH SOAL
    public function create()
    {
        return view('soal.create');
    }

    // SIMPAN SOAL
    public function store(Request $request)
    {
        $request->validate([
            'pertanyaan' => 'required',
            'skala_likert' => 'required|integer',
        ]);

        Soal::create($request->all());

        return redirect()->route('soal.index')
                         ->with('success', 'Soal berhasil ditambah!');
    }

    // FORM EDIT
    public function edit($id)
    {
        $soal = Soal::findOrFail($id);
        return view('soal.edit', compact('soal'));
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $request->validate([
            'pertanyaan' => 'required',
            'skala_likert' => 'required|integer',
        ]);

        $soal = Soal::findOrFail($id);
        $soal->update($request->all());

        return redirect()->route('soal.index')
                         ->with('success', 'Soal berhasil diperbarui!');
    }

    // HAPUS
    public function destroy($id)
    {
        Soal::destroy($id);

        return redirect()->route('soal.index')
                         ->with('success', 'Soal berhasil dihapus!');
    }
}
