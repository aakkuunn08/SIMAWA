<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'berita';
    protected $primaryKey = 'id_berita';

    protected $fillable = [
        'user_id',
        'judul_berita', // Pastikan pakai 'judul_berita' sesuai migrasi terakhir
        'konten',       // Kolom ini harus ada di database
        'tanggal_publikasi',
        'gambar',
        'published'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}