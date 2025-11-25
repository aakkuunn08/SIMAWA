<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataOrganisasi extends Model
{
    use HasFactory;

    protected $table = 'dataorganisasi';
    protected $primaryKey = 'id_organisasi';

    protected $fillable = [
        'kode_kepengurusan',
        'nama_organisasi',
        'deskripsi_organisasi',
        'email',
        'whatsapp',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
