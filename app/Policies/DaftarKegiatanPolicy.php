<?php

namespace App\Policies;

use App\Models\DaftarKegiatan;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DaftarKegiatanPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, DaftarKegiatan $daftarKegiatan): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    // app/Policies/KegiatanPolicy.php

    public function update(User $user, DaftarKegiatan $kegiatan)
    {
        // Boleh edit jika user adalah Admin BEM ATAU Pembuat Kegiatan
        return $user->hasRole('adminbem') || $user->id === $kegiatan->user_id;
    }

    public function delete(User $user, DaftarKegiatan $kegiatan)
    {
        // Sama, boleh hapus jika BEM atau Pembuatnya
        return $user->hasRole('adminbem') || $user->id === $kegiatan->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, DaftarKegiatan $daftarKegiatan): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, DaftarKegiatan $daftarKegiatan): bool
    {
        //
    }
}
