<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TesMinat extends Model
{
    use HasFactory;

    protected $table = 'tes_minat';
    protected $primaryKey = 'id_tes';

    protected $fillable = [
        'id_akun',
        'id_jawaban',
        'id_soal',
        'hasil_rekomendasi',
    ];

    public function akun()
    {
        return $this->belongsTo(Akun::class, 'id_akun', 'id_akun');
    }

    public function jawaban()
    {
        return $this->belongsTo(Jawaban::class, 'id_jawaban', 'id_jawaban');
    }

    public function soal()
    {
        return $this->belongsTo(Soal::class, 'id_soal', 'id_soal');
    }
}
