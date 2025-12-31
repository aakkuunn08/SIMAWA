<?php

namespace App\Policies;

use App\Models\DaftarKegiatan;
use App\Models\User;
use Illuminate\Auth\Access\Response; 

class DaftarKegiatanPolicy
{
    public function update(User $user, DaftarKegiatan $kegiatan)
    {
        // Logika sama, tapi return-nya pakai Response
        if ($user->hasRole('admin_bem') || $user->id === $kegiatan->user_id) {
            return Response::allow();
        }

        // Ini pesan yang akan dikirim ke layar nanti
        return Response::deny('Akses Ditolak: Anda bukan pemilik kegiatan ini!');
    }

    // Lakukan hal yang sama untuk delete jika mau
    public function delete(User $user, DaftarKegiatan $kegiatan)
    {
        if ($user->hasRole('admin_bem') || $user->id === $kegiatan->user_id) {
            return Response::allow();
        }

        return Response::deny('Akses Ditolak: Anda tidak berhak menghapus kegiatan ini!');
    }
}