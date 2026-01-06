<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Ormawa;
use App\Models\TipeOrmawa;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AccountController extends Controller
{
    public function index()
    {
        $accounts = User::with(['ormawa.tipe'])
            ->where('role', 'adminukm')
            ->get();

        return view('admin.accounts.index', compact('accounts'));
    }

    public function create()
    {
        // Ambil tipe sesuai urutan ID dari seeder (UKM & SC biasanya ID 1 & 2)
        $tipes = TipeOrmawa::orderBy('id', 'ASC')->get();

        return view('admin.accounts.form', [
            'account' => null,
            'isEdit' => false,
            'tipes' => $tipes
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'profile_photo' => ['nullable', 'image', 'max:2048'],
            'tipe_ormawa_id' => ['required', 'exists:tipe_ormawas,id'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
            'role' => 'adminukm',
        ]);
        
        $user->assignRole('adminukm');

        $path = null;
        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('logos', 'public');
            $user->update(['profile_photo_path' => $path]);
        }

        Ormawa::create([
            'user_id' => $user->id,
            'nama' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'tipe_ormawa_id' => $validated['tipe_ormawa_id'],
            'logo' => $path ? 'storage/' . $path : 'images/logobem.png',
            'deskripsi' => 'Profil organisasi ' . $validated['name'],
        ]);

        return redirect()->route('adminbem.accounts.index')->with('success', 'Akun berhasil dibuat!');
    }

    public function edit($id)
    {
        $account = User::with('ormawa')->findOrFail($id);
        $tipes = TipeOrmawa::orderBy('id', 'ASC')->get();

        return view('admin.accounts.form', [
            'account' => $account,
            'isEdit' => true,
            'tipes' => $tipes
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username,' . $id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'profile_photo' => ['nullable', 'image', 'max:2048'],
            'tipe_ormawa_id' => ['required', 'exists:tipe_ormawas,id'],
        ]);

        $user->update(['name' => $validated['name'], 'username' => $validated['username']]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        $ormawaData = [
            'nama' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'tipe_ormawa_id' => $validated['tipe_ormawa_id'],
        ];

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }
            $path = $request->file('profile_photo')->store('logos', 'public');
            $user->update(['profile_photo_path' => $path]);
            $ormawaData['logo'] = 'storage/' . $path;
        }

        $user->ormawa()->updateOrCreate(['user_id' => $user->id], $ormawaData);

        return redirect()->route('adminbem.accounts.index')->with('success', 'Akun diperbarui!');
    }

    public function storeTipe(Request $request)
    {
        $request->validate(['nama_tipe' => 'required|string|unique:tipe_ormawas,nama_tipe']);
        TipeOrmawa::create(['nama_tipe' => $request->nama_tipe]);
        return back()->with('success', 'Tipe baru berhasil ditambahkan!');
    }

    public function destroyTipe($id)
    {
        $tipe = TipeOrmawa::findOrFail($id);
        if (Ormawa::where('tipe_ormawa_id', $id)->exists()) {
            return back()->with('error', 'Tipe tidak bisa dihapus karena masih digunakan!');
        }
        $tipe->delete();
        return back()->with('success', 'Tipe berhasil dihapus!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }
        $user->delete();
        return back()->with('success', 'Akun dihapus!');
    }
}