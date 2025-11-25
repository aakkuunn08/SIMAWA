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
        return view('dashboard');
    })->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__.'/auth.php';
