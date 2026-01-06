<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipeOrmawa;
use Illuminate\Support\Facades\DB;

class TipeOrmawaSeeder extends Seeder
{
    public function run()
    {
        // Masukkan data yang benar sesuai request-mu
        $data = [
            ['nama_tipe' => 'UKM (Unit Kegiatan Mahasiswa)'],
            ['nama_tipe' => 'SC (Study Club)'],
        ];

        foreach ($data as $tipe) {
            TipeOrmawa::create($tipe);
        }
    }
}