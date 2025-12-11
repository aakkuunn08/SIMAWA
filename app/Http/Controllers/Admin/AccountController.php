<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\DataOrganisasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;

class AccountController extends Controller
{
    /**
     * Display a listing of accounts (organizations with their users)
     * Only accessible by adminbem
     */
    public function index()
    {
        // Get all users with their ormawa information (adminukm accounts)
        $accounts = User::with(['dataOrganisasi', 'ormawa'])
            ->where('role', 'adminukm')
            ->orWhereHas('roles', function($query) {
                $query->where('name', 'adminukm');
            })
            ->get();

        return view('admin.accounts.index', compact('accounts'));
    }

    /**
     * Show the form for creating a new account
     */
    public function create()
    {
        return view('admin.accounts.form', [
            'account' => null,
            'isEdit' => false
        ]);
    }

    /**
     * Store a newly created account in storage
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'profile_photo' => ['nullable', 'image', 'max:2048'], // max 2MB
        ]);

        // Create user
        $user = User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
            'role' => 'adminukm',
        ]);

        // Assign role using Spatie
        $user->assignRole('adminukm');

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('logos', 'public');
            $user->update(['profile_photo_path' => $path]);
        }

        // Redirect to ormawa form to add organization information
        return redirect()->route('adminbem.ormawa.create', $user->id)
            ->with('success', 'Akun berhasil dibuat! Silakan tambahkan informasi organisasi.');
    }

    /**
     * Show the form for editing the specified account
     */
    public function edit($id)
    {
        $account = User::findOrFail($id);

        // Ensure only adminukm accounts can be edited
        if (!$account->hasRole('adminukm') && $account->role !== 'adminukm') {
            abort(403, 'Hanya akun adminukm yang bisa diedit');
        }

        return view('admin.accounts.form', [
            'account' => $account,
            'isEdit' => true
        ]);
    }

    /**
     * Update the specified account in storage
     */
    public function update(Request $request, $id)
    {
        $account = User::findOrFail($id);

        // Ensure only adminukm accounts can be edited
        if (!$account->hasRole('adminukm') && $account->role !== 'adminukm') {
            abort(403, 'Hanya akun adminukm yang bisa diedit');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username,' . $id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'profile_photo' => ['nullable', 'image', 'max:2048'],
        ]);

        // Update basic info
        $account->update([
            'name' => $validated['name'],
            'username' => $validated['username'],
        ]);

        // Update password only if provided
        if (!empty($validated['password'])) {
            $account->update([
                'password' => Hash::make($validated['password'])
            ]);
        }

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            if ($account->profile_photo_path) {
                Storage::disk('public')->delete($account->profile_photo_path);
            }

            $path = $request->file('profile_photo')->store('logos', 'public');
            $account->update(['profile_photo_path' => $path]);
            
            // Update logo in ormawa if exists
            if ($account->ormawa) {
                $account->ormawa->update([
                    'logo' => 'storage/' . $path
                ]);
            }
        }

        return redirect()->route('adminbem.accounts.index')
            ->with('success', 'Akun berhasil diperbarui!');
    }

    /**
     * Remove the specified account from storage
     */
    public function destroy($id)
    {
        $account = User::findOrFail($id);

        // Ensure only adminukm accounts can be deleted
        if (!$account->hasRole('adminukm') && $account->role !== 'adminukm') {
            abort(403, 'Hanya akun adminukm yang bisa dihapus');
        }

        // Delete profile photo if exists
        if ($account->profile_photo_path) {
            Storage::disk('public')->delete($account->profile_photo_path);
        }

        $account->delete();

        return redirect()->route('adminbem.accounts.index')
            ->with('success', 'Akun berhasil dihapus!');
    }
}
