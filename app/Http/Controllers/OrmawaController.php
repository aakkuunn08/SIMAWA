<?php

namespace App\Http\Controllers;

use App\Models\Ormawa;

class OrmawaController extends Controller
{
    public function show($slug)
    {

        if ($slug === 'bem') {
            // BEM: kalau belum ada di DB, buat; kalau sudah ada, ambil
            $ormawa = Ormawa::firstOrCreate(
                ['slug' => 'bem'],
                [
                    'nama'      => 'Badan Eksekutif Mahasiswa',
                    'logo'      => 'images/logobem.png',
                    'tipe'      => 'bem',
                    'deskripsi' => 'BEM ITH sebagai organisasi mahasiswa tingkat institut...',
                ]
            );
        } else {
            // UKM lain: hero, hcc, seni, olahraga, dll
            $ormawa = Ormawa::where('slug', $slug)->firstOrFail();
        }

        return view('ormawa', compact('ormawa'));
    }
}
