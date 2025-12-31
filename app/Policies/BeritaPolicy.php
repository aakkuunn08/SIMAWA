<?php

namespace App\Policies;

use App\Models\Berita;
use App\Models\User;

class BeritaPolicy
{
    /**
     * AdminBEM bisa update semua.
     * AdminUKM hanya bisa update berita miliknya sendiri.
     */
    public function update(User $user, Berita $berita)
    {
        // Cek jika user memiliki role adminbem (Super Admin)
        if ($user->hasRole('adminbem')) {
            return true;
        }

        // Jika bukan adminbem, cek apakah user_id berita cocok dengan id user yang login
        return $user->id === $berita->user_id;
    }

    public function delete(User $user, Berita $berita)
    {
        if ($user->hasRole('adminbem')) {
            return true;
        }

        return $user->id === $berita->user_id;
    }
}