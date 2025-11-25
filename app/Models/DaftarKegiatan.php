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
        'user_id',
        'nama_kegiatan',
        'tanggal_kegiatan',
        'status_kegiatan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function lpj()
    {
        return $this->hasOne(Lpj::class, 'id_kegiatan', 'id_kegiatan');
    }
}
