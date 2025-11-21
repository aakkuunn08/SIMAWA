<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    use HasFactory;

    protected $table = 'soal';
    protected $primaryKey = 'id_soal';

    protected $fillable = [
        'pertanyaan',
        'skala_likert',
    ];

    public function jawaban()
    {
        return $this->hasMany(Jawaban::class, 'id_soal', 'id_soal');
    }

    public function tesMinat()
    {
        return $this->hasMany(TesMinat::class, 'id_soal', 'id_soal');
    }
}
