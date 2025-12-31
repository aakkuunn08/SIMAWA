<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lpj extends Model
{
    use HasFactory;

    protected $table = 'lpj';
    protected $primaryKey = 'id_lpj';

    protected $fillable = [
        'id_kegiatan',
        'file_lpj',
        'nama_lpj',
        'tanggal_upload',
        'status_lpj',
    ];

    public function kegiatan()
    {
        return $this->belongsTo(DaftarKegiatan::class, 'id_kegiatan', 'id_kegiatan');
    }
}
