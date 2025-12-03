<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\OrmawaController;
use App\Http\Controllers\TesMinatController;
use App\Http\Controllers\DaftarKegiatanController;
use Illuminate\Support\Facades\Route;
use App\Models\Ormawa;
use App\Models\DaftarKegiatan;

Route::get('/', function () {
    $ormawas = Ormawa::all();
    
    // Get events from database
    $kegiatan = DaftarKegiatan::all();
    $sevents = [];
    foreach ($kegiatan as $k) {
        $date = $k->tanggal_kegiatan;
        if (!isset($sevents[$date])) {
            $sevents[$date] = [];
        }
        $sevents[$date][] = [
            'id' => $k->id_kegiatan,
            'nama' => $k->nama_kegiatan,
            'tanggal_kegiatan' => $k->tanggal_kegiatan,
            'tempat' => $k->tempat,
            'waktu_mulai' => $k->waktu_mulai ? date('H.i', strtotime($k->waktu_mulai)) : null,
            'waktu_selesai' => $k->waktu_selesai ? date('H.i', strtotime($k->waktu_selesai)) : null,
        ];
    }
    
    return view('home', compact('ormawas', 'sevents'));
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
        
        // Get events from database
        $kegiatan = DaftarKegiatan::all();
        $sevents = [];
        foreach ($kegiatan as $k) {
            $date = $k->tanggal_kegiatan;
            if (!isset($sevents[$date])) {
                $sevents[$date] = [];
            }
            $sevents[$date][] = [
                'id' => $k->id_kegiatan,
                'nama' => $k->nama_kegiatan,
                'tanggal_kegiatan' => $k->tanggal_kegiatan,
                'tempat' => $k->tempat,
                'waktu_mulai' => $k->waktu_mulai ? date('H.i', strtotime($k->waktu_mulai)) : null,
                'waktu_selesai' => $k->waktu_selesai ? date('H.i', strtotime($k->waktu_selesai)) : null,
            ];
        }
        
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
    
    // Kegiatan Management - hanya AdminBEM yang bisa mengelola
    Route::get('/kegiatan/events', [DaftarKegiatanController::class, 'getEvents'])->name('kegiatan.events');
    Route::post('/kegiatan', [DaftarKegiatanController::class, 'store'])->name('kegiatan.store');
    Route::get('/kegiatan/{id}', [DaftarKegiatanController::class, 'show'])->name('kegiatan.show');
    Route::put('/kegiatan/{id}', [DaftarKegiatanController::class, 'update'])->name('kegiatan.update');
    Route::delete('/kegiatan/{id}', [DaftarKegiatanController::class, 'destroy'])->name('kegiatan.destroy');
    
    // Placeholder untuk fitur super admin
    Route::get('/adminbem/users', function () {
        return 'User Management - Only AdminBEM can access this';
    })->name('adminbem.users');
    
    Route::get('/adminbem/settings', function () {
        return 'System Settings - Only AdminBEM can access this';
    })->name('adminbem.settings');
});

require __DIR__.'/auth.php';
