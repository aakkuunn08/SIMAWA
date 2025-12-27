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

<<<<<<< HEAD
    /**
     * Show form to edit ormawa information
     */
    public function edit($id)
    {
        $ormawa = Ormawa::with('user')->findOrFail($id);

        return view('admin.ormawa.form', [
            'user' => $ormawa->user,
            'ormawa' => $ormawa,
            'isEdit' => true
        ]);
    }

    /**
     * Update ormawa information
     */
    public function update(Request $request, $id)
    {
        $ormawa = Ormawa::findOrFail($id);

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:ormawa,slug,' . $id],
            'tipe' => ['required', 'in:ukm,bem,komunitas'],
            'deskripsi' => ['nullable', 'string'],
        ]);

        // Update logo if user's profile photo changed
        if ($ormawa->user && $ormawa->user->profile_photo_path) {
            $validated['logo'] = 'storage/' . $ormawa->user->profile_photo_path;
        }

        $ormawa->update($validated);

        return redirect()->route('adminbem.accounts.index')
            ->with('success', 'Informasi ormawa berhasil diperbarui!');
    }

    /**
     * Update content in-place (AJAX)
     * Only accessible by adminbem
     */
    public function updateContent(Request $request, $slug)
    {
        $ormawa = Ormawa::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'field' => ['required', 'in:vision,mission,structure'],
            'content' => ['required', 'string'],
        ]);

        // For now, we'll store in deskripsi field as JSON
        // You might want to add separate columns for vision, mission, structure
        $currentData = json_decode($ormawa->deskripsi, true) ?? [];
        $currentData[$validated['field']] = $validated['content'];
        
        $ormawa->update([
            'deskripsi' => json_encode($currentData)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Content updated successfully'
        ]);
    }
=======
    // Note: edit() and update() methods have been removed
    // Ormawa information can only be created, not edited after creation
>>>>>>> c93fb56b2ec080adc226afce1b9df08077a64778
}
