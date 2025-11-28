<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasRoles;

    /**
     * Kolom yang boleh diisi (register / update)
     */
    protected $fillable = [
        'name',
        'username',    // kalau nanti tidak pakai email, bisa diganti 'username'
        'password',
        'role',         // tambahkan kolom role
        'is_admin',     // tambahkan kolom is_admin untuk backward compatibility
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

    /**
     * Helper method: Cek apakah user adalah admin
     * Uses Spatie's hasRole() method with fallback to legacy role column
     * 
     * @return bool
     */
    public function isAdmin()
    {
        // Check using Spatie first, fallback to legacy column
        return $this->hasRole('admin') || $this->role === 'admin';
    }

    /**
     * Helper method: Cek apakah user adalah adminbem (super admin)
     * Uses Spatie's hasRole() method with fallback to legacy role column
     * 
     * @return bool
     */
    public function isAdminBem()
    {
        // Check using Spatie first, fallback to legacy column
        return $this->hasRole('adminbem') || $this->role === 'adminbem';
    }

    /**
     * Helper method: Cek apakah user adalah admin atau adminbem
     * Uses Spatie's hasAnyRole() method with fallback to legacy column
     * 
     * @return bool
     */
    public function isAnyAdmin()
    {
        // Check using Spatie first, fallback to legacy column
        return $this->hasAnyRole(['admin', 'adminbem']) || in_array($this->role, ['admin', 'adminbem']);
    }

    /**
     * Override Spatie's hasRole to maintain backward compatibility
     * This allows both Spatie roles and legacy role column to work
     * 
     * @param string|array|\Spatie\Permission\Contracts\Role|\Illuminate\Support\Collection $roles
     * @param string|null $guard
     * @return bool
     */
    public function hasRole($roles, string $guard = null): bool
    {
        // Try Spatie's method first
        if (parent::hasRole($roles, $guard)) {
            return true;
        }

        // Fallback to legacy role column for backward compatibility
        if (is_string($roles)) {
            return $this->role === $roles;
        }

        if (is_array($roles)) {
            return in_array($this->role, $roles);
        }

        return false;
    }
}
