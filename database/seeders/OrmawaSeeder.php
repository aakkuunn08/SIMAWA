<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ormawa;

class OrmawaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Ormawa::insert([
            [
                'nama' => 'Badan Eksekutif Mahasiswa',
                'slug' => 'bem',
                'logo' => 'images/logobem.png',
                'tipe' => 'bem',
                'deskripsi' => 'BEM ITH sebagai organisasi mahasiswa tingkat institut...',
            ],
            [
                'nama' => 'HERO',
                'slug' => 'hero',
                'logo' => 'images/logohero.png',
                'tipe' => 'ukm',
                'deskripsi' => 'UKM HERO bergerak di bidang robotik dan teknologi...',
            ],
            [
                'nama' => 'HCC',
                'slug' => 'hcc',
                'logo' => 'images/logohcc.png',
                'tipe' => 'ukm',
                'deskripsi' => 'Habibie Coding Club berfokus pada pengembangan software & coding...',
            ],
            [
                'nama' => 'SENI',
                'slug' => 'seni',
                'logo' => 'images/logoseni.png',
                'tipe' => 'ukm',
                'deskripsi' => 'UKM Seni mewadahi mahasiswa di bidang seni musik, tari, dan kreativitas...',
            ],
            [
                'nama' => 'OLAHRAGA',
                'slug' => 'olahraga',
                'logo' => 'images/olahraga.png',
                'tipe' => 'ukm',
                'deskripsi' => 'UKM Olahraga menaungi berbagai cabang olahraga seperti futsal, basket, voli, dan lainnya...',
            ],
        ]);
    }
}
