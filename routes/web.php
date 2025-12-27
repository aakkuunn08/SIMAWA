<?php

use App\Models\Ormawa;
use App\Models\DaftarKegiatan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrmawaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TesMinatController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DaftarKegiatanController;
use App\Http\Controllers\DaftarKegiatanControllerKegiatanController;

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

// Update content in-place (only for AdminBEM)
Route::post('/ormawa/{slug}/update-content', [OrmawaController::class, 'updateContent'])
    ->middleware(['auth', 'adminbem'])
    ->name('ormawa.updateContent');
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

// Route yang bisa diakses oleh AdminBEM dan AdminUKM
Route::middleware(['auth', 'admin'])->group(function () {
    // Kegiatan Management - AdminBEM dan AdminUKM bisa mengelola kegiatan mereka
    Route::get('/kegiatan/events', [DaftarKegiatanController::class, 'getEvents'])->name('kegiatan.events');
    Route::post('/kegiatan', [DaftarKegiatanController::class, 'store'])->name('kegiatan.store');
    Route::get('/kegiatan/{id}', [DaftarKegiatanController::class, 'show'])->name('kegiatan.show');
    Route::put('/kegiatan/{id}', [DaftarKegiatanController::class, 'update'])->name('kegiatan.update');
    Route::delete('/kegiatan/{id}', [DaftarKegiatanController::class, 'destroy'])->name('kegiatan.destroy');

    // Route untuk Upload LPJ
    Route::post('/kegiatan/{id}/upload-lpj', [DaftarKegiatanController::class, 'uploadLpj'])->name('kegiatan.uploadLpj');
});

// Route yang HANYA bisa diakses oleh AdminBEM (Super Admin)
Route::middleware(['auth', 'adminbem'])->group(function () {
    // Account Management - hanya AdminBEM yang bisa mengelola akun
    Route::get('/adminbem/accounts', [App\Http\Controllers\Admin\AccountController::class, 'index'])->name('adminbem.accounts.index');
    Route::get('/adminbem/accounts/create', [App\Http\Controllers\Admin\AccountController::class, 'create'])->name('adminbem.accounts.create');
    Route::post('/adminbem/accounts', [App\Http\Controllers\Admin\AccountController::class, 'store'])->name('adminbem.accounts.store');
    Route::get('/adminbem/accounts/{id}/edit', [App\Http\Controllers\Admin\AccountController::class, 'edit'])->name('adminbem.accounts.edit');
    Route::put('/adminbem/accounts/{id}', [App\Http\Controllers\Admin\AccountController::class, 'update'])->name('adminbem.accounts.update');
    Route::delete('/adminbem/accounts/{id}', [App\Http\Controllers\Admin\AccountController::class, 'destroy'])->name('adminbem.accounts.destroy');
    
    // Ormawa Management - hanya AdminBEM yang bisa mengelola informasi ormawa
    Route::get('/adminbem/accounts/{userId}/ormawa/create', [OrmawaController::class, 'create'])->name('adminbem.ormawa.create');
    Route::post('/adminbem/accounts/{userId}/ormawa', [OrmawaController::class, 'store'])->name('adminbem.ormawa.store');
    Route::get('/adminbem/ormawa/{id}/edit', [OrmawaController::class, 'edit'])->name('adminbem.ormawa.edit');
    Route::put('/adminbem/ormawa/{id}', [OrmawaController::class, 'update'])->name('adminbem.ormawa.update');
    
    // Hasil Tes Minat - hanya AdminBEM yang bisa melihat dan mengelola
    Route::get('/tesminatbem/menu', [TesMinatController::class, 'showMenu'])->name('tesminatbem.menu');
    Route::get('/tesminatbem', [TesMinatController::class, 'showResults'])->name('tesminatbem.results');
    Route::delete('/tesminatbem/{id}', [TesMinatController::class, 'delete'])->name('tesminatbem.delete');
    
    // Kelola Pertanyaan Tes Minat - hanya AdminBEM yang bisa mengelola
    Route::get('/tesminatbem/pertanyaan', [TesMinatController::class, 'manageQuestions'])->name('tesminatbem.pertanyaan');
    Route::get('/tesminatbem/pertanyaan/data', [TesMinatController::class, 'getQuestionsData'])->name('tesminatbem.pertanyaan.data');
    Route::post('/tesminatbem/pertanyaan', [TesMinatController::class, 'storeQuestion'])->name('tesminatbem.pertanyaan.store');
    Route::put('/tesminatbem/pertanyaan/{id}', [TesMinatController::class, 'updateQuestion'])->name('tesminatbem.pertanyaan.update');
    Route::delete('/tesminatbem/pertanyaan/{id}', [TesMinatController::class, 'deleteQuestion'])->name('tesminatbem.pertanyaan.delete');
    
    // Placeholder untuk fitur super admin lainnya
    Route::get('/adminbem/settings', function () {
        return 'System Settings - Only AdminBEM can access this';
    })->name('adminbem.settings');
});

// Debug route - Check all users and their roles
Route::get('/check-users-roles', function () {
    $users = \App\Models\User::all();
    $roles = \Spatie\Permission\Models\Role::all();
    
    $output = "<h1>Users and Roles Check</h1>";
    $output .= "<h2>Total Users: " . $users->count() . "</h2>";
    
    foreach ($users as $user) {
        $output .= "<div style='border: 1px solid #ccc; padding: 10px; margin: 10px 0;'>";
        $output .= "<strong>ID:</strong> " . $user->id . "<br>";
        $output .= "<strong>Name:</strong> " . $user->name . "<br>";
        $output .= "<strong>Username:</strong> " . $user->username . "<br>";
        $output .= "<strong>Legacy Role Column:</strong> " . ($user->role ?? 'NULL') . "<br>";
        $output .= "<strong>is_admin:</strong> " . ($user->is_admin ?? 'NULL') . "<br>";
        
        $spatieRoles = $user->roles->pluck('name')->toArray();
        $output .= "<strong>Spatie Roles:</strong> " . (empty($spatieRoles) ? 'NONE' : implode(', ', $spatieRoles)) . "<br>";
        
        $output .= "<br><strong>Testing hasRole() method:</strong><br>";
        $output .= "- hasRole('adminbem'): " . ($user->hasRole('adminbem') ? 'YES' : 'NO') . "<br>";
        $output .= "- hasRole('adminukm'): " . ($user->hasRole('adminukm') ? 'YES' : 'NO') . "<br>";
        $output .= "- hasRole('adminbem','adminukm'): " . ($user->hasRole('adminbem','adminukm') ? 'YES' : 'NO') . "<br>";
        
        $output .= "<br><strong>Testing hasAnyRole() method:</strong><br>";
        $output .= "- hasAnyRole(['adminbem','adminukm']): " . ($user->hasAnyRole(['adminbem','adminukm']) ? 'YES' : 'NO') . "<br>";
        
        $output .= "</div>";
    }
    
    $output .= "<h2>Available Roles in Database</h2>";
    if ($roles->isEmpty()) {
        $output .= "<p style='color: red;'>No roles found! Run: php artisan db:seed --class=RolePermissionSeeder</p>";
    } else {
        foreach ($roles as $role) {
            $output .= "- " . $role->name . " (ID: " . $role->id . ")<br>";
        }
    }
    
    return $output;
})->name('check.users.roles');
