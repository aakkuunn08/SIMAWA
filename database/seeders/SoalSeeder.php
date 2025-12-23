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
        // Hapus semua data soal yang ada sebelumnya untuk menghindari duplikasi
        Soal::query()->delete();

        // Data pertanyaan untuk tes minat berdasarkan RIASEC
        // Setiap pertanyaan menggunakan skala Likert 1-5 (1: Sangat Tidak Suka, 5: Sangat Suka)
        // Total 25 soal: 5 soal per UKM
        $soals = [
            // HERO (Robotic) - Realistic (R): Hands-on, mechanical, practical
            [
                'pertanyaan' => 'Saya suka bekerja dengan mesin dan peralatan mekanik',
                'skala_likert' => 5,
                'kategori' => 'HERO',
            ],
            [
                'pertanyaan' => 'Saya tertarik membangun dan merakit perangkat elektronik',
                'skala_likert' => 5,
                'kategori' => 'HERO',
            ],
            [
                'pertanyaan' => 'Saya suka memecahkan masalah teknis dengan cara praktis',
                'skala_likert' => 5,
                'kategori' => 'HERO',
            ],
            [
                'pertanyaan' => 'Saya tertarik dengan dunia robotika dan otomasi',
                'skala_likert' => 5,
                'kategori' => 'HERO',
            ],
            [
                'pertanyaan' => 'Saya suka melakukan eksperimen dengan komponen hardware',
                'skala_likert' => 5,
                'kategori' => 'HERO',
            ],

            // HCC (Web Coding) - Investigative (I): Analytical, problem-solving, intellectual
            [
                'pertanyaan' => 'Saya suka menganalisis dan memecahkan masalah logika',
                'skala_likert' => 5,
                'kategori' => 'HCC',
            ],
            [
                'pertanyaan' => 'Saya tertarik belajar bahasa pemrograman baru',
                'skala_likert' => 5,
                'kategori' => 'HCC',
            ],
            [
                'pertanyaan' => 'Saya suka membuat aplikasi dan website',
                'skala_likert' => 5,
                'kategori' => 'HCC',
            ],
            [
                'pertanyaan' => 'Saya tertarik dengan teknologi informasi dan data',
                'skala_likert' => 5,
                'kategori' => 'HCC',
            ],
            [
                'pertanyaan' => 'Saya suka bekerja dengan kode dan algoritma',
                'skala_likert' => 5,
                'kategori' => 'HCC',
            ],

            // Seni - Artistic (A): Creative, expressive, imaginative
            [
                'pertanyaan' => 'Saya suka mengekspresikan diri melalui seni visual',
                'skala_likert' => 5,
                'kategori' => 'Seni',
            ],
            [
                'pertanyaan' => 'Saya tertarik membuat karya seni yang unik dan kreatif',
                'skala_likert' => 5,
                'kategori' => 'Seni',
            ],
            [
                'pertanyaan' => 'Saya suka berpartisipasi dalam kegiatan seni dan budaya',
                'skala_likert' => 5,
                'kategori' => 'Seni',
            ],
            [
                'pertanyaan' => 'Saya tertarik dengan musik, tari, atau teater',
                'skala_likert' => 5,
                'kategori' => 'Seni',
            ],
            [
                'pertanyaan' => 'Saya suka mengembangkan imajinasi dan kreativitas',
                'skala_likert' => 5,
                'kategori' => 'Seni',
            ],

            // Olahraga - Social (S): Team-oriented, active, cooperative
            [
                'pertanyaan' => 'Saya suka berolahraga dan menjaga kebugaran fisik',
                'skala_likert' => 5,
                'kategori' => 'Olahraga',
            ],
            [
                'pertanyaan' => 'Saya tertarik dengan kegiatan olahraga tim',
                'skala_likert' => 5,
                'kategori' => 'Olahraga',
            ],
            [
                'pertanyaan' => 'Saya suka tantangan fisik dan kompetisi olahraga',
                'skala_likert' => 5,
                'kategori' => 'Olahraga',
            ],
            [
                'pertanyaan' => 'Saya tertarik mengorganisir acara olahraga',
                'skala_likert' => 5,
                'kategori' => 'Olahraga',
            ],
            [
                'pertanyaan' => 'Saya suka bekerja sama dalam tim untuk mencapai tujuan',
                'skala_likert' => 5,
                'kategori' => 'Olahraga',
            ],

            // MPM (Mushallah) - Social/Enterprising (S/E): Community-focused, leadership, service
            [
                'pertanyaan' => 'Saya suka membantu orang lain dan berkontribusi untuk masyarakat',
                'skala_likert' => 5,
                'kategori' => 'MPM',
            ],
            [
                'pertanyaan' => 'Saya tertarik dengan kegiatan keagamaan dan spiritual',
                'skala_likert' => 5,
                'kategori' => 'MPM',
            ],
            [
                'pertanyaan' => 'Saya suka mengorganisir acara sosial dan komunitas',
                'skala_likert' => 5,
                'kategori' => 'MPM',
            ],
            [
                'pertanyaan' => 'Saya tertarik menjadi pemimpin dalam kegiatan kelompok',
                'skala_likert' => 5,
                'kategori' => 'MPM',
            ],
            [
                'pertanyaan' => 'Saya suka berbagi pengetahuan dan menginspirasi orang lain',
                'skala_likert' => 5,
                'kategori' => 'MPM',
            ],
        ];

        // Acak urutan pertanyaan agar tidak berurutan berdasarkan UKM
        shuffle($soals);

        // Insert semua pertanyaan ke database
        foreach ($soals as $soal) {
            Soal::create($soal);
        }
        
        $this->command->info('✓ Berhasil menambahkan ' . count($soals) . ' pertanyaan tes minat');
    }
}
