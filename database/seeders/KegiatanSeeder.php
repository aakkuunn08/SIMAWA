<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DaftarKegiatan;
use App\Models\User;

class KegiatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get admin BEM user (assuming first user is admin)
        $adminUser = User::first();
        
        if (!$adminUser) {
            $this->command->error('No user found. Please create a user first.');
            return;
        }

        // Sample activities
        $kegiatan = [
            [
                'user_id' => $adminUser->id,
                'nama_kegiatan' => 'Seminar Robotika',
                'tanggal_kegiatan' => '2025-12-15',
                'tempat' => 'Aula Kampus 2 ITH',
                'waktu_mulai' => '07:30:00',
                'waktu_selesai' => '09:10:00',
                'status_kegiatan' => 'scheduled',
            ],
            [
                'user_id' => $adminUser->id,
                'nama_kegiatan' => 'Workshop Web Development',
                'tanggal_kegiatan' => '2025-12-20',
                'tempat' => 'Lab Komputer Gedung A',
                'waktu_mulai' => '13:00:00',
                'waktu_selesai' => '16:00:00',
                'status_kegiatan' => 'scheduled',
            ],
            [
                'user_id' => $adminUser->id,
                'nama_kegiatan' => 'Rapat BEM',
                'tanggal_kegiatan' => '2025-12-10',
                'tempat' => 'Ruang Rapat BEM',
                'waktu_mulai' => '14:00:00',
                'waktu_selesai' => '16:00:00',
                'status_kegiatan' => 'scheduled',
            ],
            [
                'user_id' => $adminUser->id,
                'nama_kegiatan' => 'Futsal Cup ITH',
                'tanggal_kegiatan' => '2025-12-25',
                'tempat' => 'Lapangan Futsal ITH',
                'waktu_mulai' => '08:00:00',
                'waktu_selesai' => '17:00:00',
                'status_kegiatan' => 'scheduled',
            ],
        ];

        foreach ($kegiatan as $k) {
            DaftarKegiatan::create($k);
        }

        $this->command->info('Sample kegiatan created successfully!');
    }
}
