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
        'user_id',
        'id_jawaban',
        'id_soal',
        'hasil_rekomendasi',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
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
