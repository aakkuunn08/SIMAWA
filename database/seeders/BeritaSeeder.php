<?php

namespace Database\Seeders;

use App\Models\Berita;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BeritaSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'user_id' => 1, // Pastikan ID user ini ada di tabel users
                'judul_berita' => 'Pelantikan Pengurus BEM ITH Periode 2026',
                'konten' => 'Badan Eksekutif Mahasiswa (BEM) Institut Teknologi Bacharuddin Jusuf Habibie resmi melantik pengurus baru untuk masa bakti 2026. Acara ini berlangsung khidmat di aula kampus dengan dihadiri oleh jajaran rektorat.',
                'tanggal_publikasi' => now(),
                'gambar' => null, // Anda bisa isi manual nanti via dashboard
                'published' => true,
            ],
            [
                'user_id' => 1,
                'judul_berita' => 'Open Recruitment UKM Olahraga',
                'konten' => 'Bagi mahasiswa yang memiliki minat di bidang olahraga, UKM Olahraga kembali membuka pendaftaran anggota baru. Tersedia berbagai cabang seperti futsal, basket, dan badminton.',
                'tanggal_publikasi' => now(),
                'gambar' => null,
                'published' => true,
            ],
            [
                'user_id' => 1,
                'judul_berita' => 'Workshop Pengembangan Karir Mahasiswa',
                'konten' => 'SIMAWA menyelenggarakan workshop daring bertajuk Strategi Membangun Portofolio di Era Digital. Kegiatan ini bertujuan untuk mempersiapkan mahasiswa menghadapi dunia kerja profesional.',
                'tanggal_publikasi' => now(),
                'gambar' => null,
                'published' => true,
            ],
        ];

        foreach ($data as $item) {
            Berita::create($item);
        }
    }
}