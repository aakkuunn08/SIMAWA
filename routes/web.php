<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

// ================= ORMAWA (TES DULU) =================
Route::get('/ormawa/{slug}', [OrmawaController::class, 'show'])->name('ormawa.show');
// =====================================================

// Semua route yang butuh login
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    // Hanya ADMIN yang boleh akses route di dalam grup ini
    Route::middleware('admin')->group(function () {

        // Form tambah user
        Route::get('/admin/users/create', [UserController::class, 'create'])
            ->name('admin.users.create');

        // Proses simpan user baru
        Route::post('/admin/users', [UserController::class, 'store'])
            ->name('admin.users.store');
    });
});

require __DIR__.'/auth.php';
