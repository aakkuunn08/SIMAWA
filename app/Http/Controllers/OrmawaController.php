<?php

namespace App\Http\Controllers;

use App\Models\Ormawa;

class OrmawaController extends Controller
{
    public function show($slug)
    {
        // Ambil data ormawa berdasarkan slug (hero, hcc, seni, olahraga, bem)
        $ormawa = Ormawa::where('slug', $slug)->firstOrFail();

        // Kirim data ke ormawa.blade.php
        return view('ormawa', compact('ormawa'));
    }
}
