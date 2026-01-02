<?php

namespace App\Http\Controllers;

use App\Models\Ormawa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrmawaController extends Controller
{
    /**
     * Display ormawa information page
     */
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

    /**
     * Show form to create ormawa information for a user
     * Only accessible by adminbem
     */
    public function create($userId)
    {
        $user = User::findOrFail($userId);
        
        // Check if user already has ormawa
        if ($user->ormawa) {
            return redirect()->route('adminbem.ormawa.edit', $user->ormawa->id)
                ->with('info', 'Akun ini sudah memiliki informasi ormawa. Silakan edit jika perlu.');
        }

        return view('admin.ormawa.form', [
            'user' => $user,
            'ormawa' => null,
            'isEdit' => false
        ]);
    }

    /**
     * Store ormawa information
     */
    public function store(Request $request, $userId)
    {
        $user = User::findOrFail($userId);

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:ormawa,slug'],
            'tipe' => ['required', 'in:ukm,bem,komunitas'],
            'deskripsi' => ['nullable', 'string'],
        ]);

        // Use user's profile photo as logo
        $logo = $user->profile_photo_path 
            ? 'storage/' . $user->profile_photo_path 
            : 'images/default-logo.png';

        $ormawa = Ormawa::create([
            'user_id' => $user->id,
            'nama' => $validated['nama'],
            'slug' => $validated['slug'],
            'logo' => $logo,
            'tipe' => $validated['tipe'],
            'deskripsi' => $validated['deskripsi'] ?? '',
        ]);

        return redirect()->route('adminbem.accounts.index')
            ->with('success', 'Informasi ormawa berhasil ditambahkan!');
    }

public function updateContent(Request $request, $slug)
{
    $request->validate([
        'field' => 'required|string',
        'content' => 'required'
    ]);

    $ormawa = Ormawa::where('slug', $slug)->firstOrFail();
    $field = $request->field;

    // Simpan ke database
    $ormawa->$field = $request->content;
    
    if ($ormawa->save()) {
        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil disimpan'
        ], 200);
    }

    return response()->json(['status' => 'error'], 500);
}
    // Note: edit() and update() methods have been removed
    // Ormawa information can only be created, not edited after creation
}
