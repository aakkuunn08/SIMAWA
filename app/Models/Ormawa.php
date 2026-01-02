<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ormawa extends Model
{
    use HasFactory;

    protected $table = 'ormawa';

    // Tambahkan vision, mission, dan structure di sini agar bisa disimpan
    protected $fillable = [
        'user_id',
        'nama',
        'slug',
        'logo',
        'tipe',
        'deskripsi',
        'vision',    
        'mission',   
        'structure', 
    ];

    /**
     * Casting structure agar otomatis menjadi array saat dipanggil di Blade
     */
    protected $casts = [
        'structure' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}