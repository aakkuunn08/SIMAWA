<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    /**
     * Kolom yang boleh diisi (register / update)
     */
    protected $fillable = [
        'name',
        'username',    // kalau nanti tidak pakai email, bisa diganti 'username'
        'password',
        'role',         // tambahkan kolom role
    ];

    /**
     * Kolom yang disembunyikan saat di-serialize (misal ke JSON)
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Cast nilai kolom (tipe data)
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relasi: 1 user punya banyak organisasi
     */
    public function dataOrganisasi()
    {
        return $this->hasMany(DataOrganisasi::class, 'user_id', 'id');
    }

    /**
     * Relasi: 1 user punya banyak kegiatan
     */
    public function daftarKegiatan()
    {
        return $this->hasMany(DaftarKegiatan::class, 'user_id', 'id');
    }

    /**
     * Relasi: 1 user punya banyak berita
     */
    public function berita()
    {
        return $this->hasMany(Berita::class, 'user_id', 'id');
    }

    /**
     * Relasi: 1 user punya banyak tes minat
     */
    public function tesMinat()
    {
        return $this->hasMany(TesMinat::class, 'user_id', 'id');
    }
}
