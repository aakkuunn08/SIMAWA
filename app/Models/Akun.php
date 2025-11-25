<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Akun extends Model
{
    use HasFactory;

    protected $table = 'akun';
    protected $primaryKey = 'id_akun';

    protected $fillable = [
        'username',
        'password',
        'role' => 'adminbem'/'admin',
    ];

    // 1 akun punya banyak organisasi
    public function organisasi()
    {
        return $this->hasMany(DataOrganisasi::class, 'id_akun', 'id_akun');
    }

    // 1 akun punya banyak kegiatan
    public function kegiatan()
    {
        return $this->hasMany(DaftarKegiatan::class, 'id_akun', 'id_akun');
    }

    // 1 akun punya banyak berita
    public function berita()
    {
        return $this->hasMany(Berita::class, 'id_akun', 'id_akun');
    }

    // 1 akun punya banyak tes minat
    public function tesMinat()
    {
        return $this->hasMany(TesMinat::class, 'id_akun', 'id_akun');
    }
}
