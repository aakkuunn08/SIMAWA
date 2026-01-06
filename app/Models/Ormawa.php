<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ormawa extends Model
{
    use HasFactory;

    protected $table = 'ormawa';

    protected $fillable = [
        'user_id',
        'nama',
        'slug',
        'logo',
        'tipe_ormawa_id', // Ini untuk menyimpan angka ID (Foreign Key)
        'vision',    
        'mission',   
        'structure', 
    ];

    protected $casts = [
        'structure' => 'array',
    ];

    // Relasi ke User (Pemilik Akun)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    //  RELASI Ke tabel TipeOrmawa
    public function tipe()
    {
        return $this->belongsTo(TipeOrmawa::class, 'tipe_ormawa_id');
    }
}