<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipeOrmawa extends Model
{
    protected $table = 'tipe_ormawas'; // Sesuaikan dengan nama tabel di migrasimu
    protected $fillable = ['nama_tipe'];
}