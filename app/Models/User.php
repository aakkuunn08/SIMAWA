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
}
