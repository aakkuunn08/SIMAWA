<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Soal;

/**
 * Seeder untuk tabel soal
 * Mengisi pertanyaan-pertanyaan untuk tes minat UKM
 */
class SoalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * @return void
     */
    public function run(): void
    {
        // Data pertanyaan untuk tes minat
        // Setiap pertanyaan menggunakan skala Likert 1-5
        $soals = [
            [
                'pertanyaan' => 'Saya tertarik belajar hal baru di bidang Sains & Teknologi (Robotik, IoT, dll)',
                'skala_likert' => 5,
            ],
            [
                'pertanyaan' => 'Saya suka olahraga dan kegiatan fisik yang menantang adrenalin',
                'skala_likert' => 5,
            ],
            [
                'pertanyaan' => 'Saya tertarik membuat karya seni atau hal yang bisa saya ekspresikan',
                'skala_likert' => 5,
            ],
            [
                'pertanyaan' => 'Saya suka berkumpul dengan orang lain dan aktif dalam kegiatan kelompok',
                'skala_likert' => 5,
            ],
            [
                'pertanyaan' => 'Saya tertarik membuat robot dan hardware elektronik',
                'skala_likert' => 5,
            ],
            [
                'pertanyaan' => 'Saya tertarik coding dan membuat aplikasi/website',
                'skala_likert' => 5,
            ],
        ];

        // Insert semua pertanyaan ke database
        foreach ($soals as $soal) {
            Soal::create($soal);
        }
        
        $this->command->info('✓ Berhasil menambahkan ' . count($soals) . ' pertanyaan tes minat');
    }
}
