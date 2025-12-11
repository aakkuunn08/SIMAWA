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
        'user_id',
        'nama',
        'slug',
        'logo',
        'tipe',
        'deskripsi',
    ];

    /**
     * Relasi: 1 ormawa dimiliki oleh 1 user (adminukm)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
