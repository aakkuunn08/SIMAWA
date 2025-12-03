<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\OrmawaController;
use App\Http\Controllers\TesMinatController;
use Illuminate\Support\Facades\Route;
use App\Models\Ormawa; // <- pastikan baris ini ada di atas, bersama use lainnya

Route::get('/', function () {
    $ormawas = Ormawa::all();   // ambil semua data ormawa dari database
    $sevents = []; // Initialize empty events array - you can populate this later with actual events
    return view('home', compact('ormawas', 'sevents')); // kirim ke view
})->name('home');

// ================= ORMAWA =================
Route::get('/ormawa/{slug}', [OrmawaController::class, 'show'])->name('ormawa.show');
// ==========================================

// ================= TES MINAT UKM =================
// Route untuk halaman tes minat - Bisa diakses tanpa login (untuk mahasiswa)
Route::get('/tesminat', [TesMinatController::class, 'index'])->name('tesminat.index');
Route::post('/tesminat/submit', [TesMinatController::class, 'submit'])->name('tesminat.submit');
// =================================================

// Semua route yang butuh login
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        $ormawas = Ormawa::all();
        $sevents = []; // Initialize empty events array
        return view('dashboard', compact('ormawas', 'sevents'));
    })->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

// Route yang hanya bisa diakses oleh Admin dan AdminBEM
Route::middleware(['auth', 'admin'])->group(function () {
    // Contoh: Kelola Kegiatan, Berita, dll
    // Route::resource('kegiatan', DaftarKegiatanController::class);
    // Route::resource('berita', BeritaController::class);
    
    // Placeholder untuk fitur admin
    Route::get('/admin/dashboard', function () {
        return view('dashboard'); // Ganti dengan view admin dashboard
    })->name('admin.dashboard');
});

// Route yang HANYA bisa diakses oleh AdminBEM (Super Admin)
Route::middleware(['auth', 'adminbem'])->group(function () {
    // User Management - hanya AdminBEM yang bisa mengelola user
    // Route::resource('users', UserController::class);
    
    // Hasil Tes Minat - hanya AdminBEM yang bisa melihat dan mengelola
    Route::get('/tesminatbem', [TesMinatController::class, 'showResults'])->name('tesminatbem.results');
    Route::delete('/tesminatbem/{id}', [TesMinatController::class, 'delete'])->name('tesminatbem.delete');
    
    // Placeholder untuk fitur super admin
    Route::get('/adminbem/users', function () {
        return 'User Management - Only AdminBEM can access this';
    })->name('adminbem.users');
    
    Route::get('/adminbem/settings', function () {
        return 'System Settings - Only AdminBEM can access this';
    })->name('adminbem.settings');
});

require __DIR__.'/auth.php';
