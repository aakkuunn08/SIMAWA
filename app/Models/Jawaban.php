<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jawaban extends Model
{
    use HasFactory;

    protected $table = 'jawaban';
    protected $primaryKey = 'id_jawaban';

    protected $fillable = [
        'id_soal',
        'nama',
        'nim',
        'tanggal_pengisian',
        'jawaban_tes',
        'skor_total',
    ];

    public function soal()
    {
        return $this->belongsTo(Soal::class, 'id_soal', 'id_soal');
    }

    public function tesMinat()
    {
        return $this->hasMany(TesMinat::class, 'id_jawaban', 'id_jawaban');
    }
}
