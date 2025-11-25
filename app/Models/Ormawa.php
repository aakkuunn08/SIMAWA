<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ormawa extends Model
{
    use HasFactory;

    // Nama tabel (opsional karena defaultnya jamak: ormawas)
    protected $table = 'ormawa';

    // Field yang boleh diisi (fillable)
    protected $fillable = [
        'nama',
        'slug',
        'logo',
        'tipe',
        'deskripsi',
    ];
}
