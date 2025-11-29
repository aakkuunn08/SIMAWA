<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\OrmawaController;
use Illuminate\Support\Facades\Route;
use App\Models\Ormawa; // <- pastikan baris ini ada di atas, bersama use lainnya

Route::get('/', function () {
    $ormawas = Ormawa::all();   // ambil semua data ormawa dari database
    return view('home', compact('ormawas')); // kirim ke view
})->name('home');

// ================= ORMAWA =================
Route::get('/ormawa/{slug}', [OrmawaController::class, 'show'])->name('ormawa.show');
// ==========================================

// Semua route yang butuh login
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        $ormawas = Ormawa::all();   
        return view('dashboard', compact('ormawas'));
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
    
    // Placeholder untuk fitur super admin
    Route::get('/adminbem/users', function () {
        return 'User Management - Only AdminBEM can access this';
    })->name('adminbem.users');
    
    Route::get('/adminbem/settings', function () {
        return 'System Settings - Only AdminBEM can access this';
    })->name('adminbem.settings');
});

require __DIR__.'/auth.php';
