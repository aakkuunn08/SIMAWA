<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarKegiatan extends Model
{
    use HasFactory;

    protected $table = 'daftar_kegiatan';
    protected $primaryKey = 'id_kegiatan';

    protected $fillable = [
        'id_akun',
        'nama_kegiatan',
        'tanggal_kegiatan',
        'status_kegiatan',
    ];

    public function akun()
    {
        return $this->belongsTo(Akun::class, 'id_akun', 'id_akun');
    }

    public function lpj()
    {
        return $this->hasOne(Lpj::class, 'id_kegiatan', 'id_kegiatan');
    }
}
