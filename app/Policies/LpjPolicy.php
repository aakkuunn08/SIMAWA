<?php

namespace App\Policies;

use App\Models\Lpj;
use App\Models\User;

class LpjPolicy
{
    /**
     * Tentukan siapa yang boleh mengupdate (edit) LPJ ini.
     */
    public function update(User $user, Lpj $lpj)
    {
        // 1. Cek apakah user adalah ADMIN BEM?
        // (Ganti 'admin_bem' sesuai nama role spatie yang kau pakai)
        if ($user->hasRole('admin_bem')) {
            return true; // BEM boleh edit punya siapa saja
        }

        // 2. Jika bukan BEM, cek apakah dia pemilik LPJ ini?
        // Pastikan di tabel 'lpjs' ada kolom 'user_id' yang menyimpan siapa pembuatnya
        return $user->id === $lpj->user_id;
    }
    
    // Opsional: Logika untuk melihat detail (view)
    // Supaya Admin UKM lain bisa lihat, tapi tidak error 403
    public function view(User $user, Lpj $lpj)
    {
        // Semua user yang login boleh melihat detail LPJ
        return true; 
    }
}