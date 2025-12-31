<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DaftarKegiatan;
use Illuminate\Support\Facades\DB; // Kita pakai DB Facade biar aman

class DaftarKegiatanSeeder extends Seeder
{
    public function run()
    {
        // AMBIL ID USER SECARA PAKSA (Angka Paling Awal)
        // Kita pakai DB::table supaya tidak pusing sama settingan Model User
        $userId = DB::table('users')->value('id'); 

        // Kalau tabel users kosong melompong, kita pakai angka 1 (semoga tidak error FK)
        if (!$userId) {
            $userId = 1;
        }

        // Data Dummy
        $kegiatan = [
            [
                'nama_kegiatan' => 'Rapat Koordinasi Awal BEM',
                'tempat' => 'Aula Gedung A',
                'waktu_mulai' => '08:00',
                'waktu_selesai' => '10:00',
            ],
            [
                'nama_kegiatan' => 'Seminar Teknologi & AI',
                'tempat' => 'Ruang Teater Kampus 2',
                'waktu_mulai' => '10:30',
                'waktu_selesai' => '12:30',
            ],
            [
                'nama_kegiatan' => 'Makan Siang & Networking',
                'tempat' => 'Kantin Pusat',
                'waktu_mulai' => '12:30',
                'waktu_selesai' => '13:30',
            ],
            [
                'nama_kegiatan' => 'Evaluasi Program Kerja Bulanan',
                'tempat' => 'Sekretariat BEM',
                'waktu_mulai' => '14:00',
                'waktu_selesai' => '16:00',
            ],
        ];

        foreach ($kegiatan as $k) {
            DaftarKegiatan::create([
                'user_id' => $userId, // Pasti Angka nih sekarang
                'nama_kegiatan' => $k['nama_kegiatan'],
                'tanggal_kegiatan' => '2025-12-29', // Tanggal disamakan
                'tempat' => $k['tempat'],
                'waktu_mulai' => $k['waktu_mulai'],
                'waktu_selesai' => $k['waktu_selesai'],
                'status_kegiatan' => 'scheduled',
            ]);
        }
    }
}