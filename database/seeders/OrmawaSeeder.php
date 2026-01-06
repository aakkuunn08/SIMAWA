<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Ormawa;
use App\Models\User;
use App\Models\TipeOrmawa;

class OrmawaSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Pastikan Tipe sudah ada di tabel tipe_ormawas
        $ukm = TipeOrmawa::where('nama_tipe', 'UKM (Unit Kegiatan Mahasiswa)')->first();
        $sc = TipeOrmawa::where('nama_tipe', 'SC (Study Club)')->first();
        $bem = TipeOrmawa::firstOrCreate(['nama_tipe' => 'BEM (Badan Eksekutif Mahasiswa)']);

        $ormawaData = [
            [
                'user' => [
                    'name' => 'HERO (Habibie Engineering Robotic of Organization)',
                    'username' => 'adminhero',
                    'password' => 'hero123',
                ],
                'ormawa' => [
                    'nama' => 'HERO',
                    'slug' => 'hero',
                    'logo' => 'images/logohero.png',
                    'tipe_id' => $ukm->id,
                    'vision' => 'UKM HERO bergerak di bidang robotik dan teknologi, mengembangkan inovasi dan prestasi mahasiswa ITH di bidang engineering dan robotika.',
                ],
            ],
            [
                'user' => [
                    'name' => 'HCC (Habibie Coding Club)',
                    'username' => 'adminhcc',
                    'password' => 'hcc123',
                ],
                'ormawa' => [
                    'nama' => 'HCC',
                    'slug' => 'hcc',
                    'logo' => 'images/logohcc.png',
                    'tipe_id' => $ukm->id,
                    'vision' => 'Habibie Coding Club berfokus pada pengembangan software, coding, dan teknologi informasi untuk mempersiapkan mahasiswa menghadapi industri digital.',
                ],
            ],
            [
                'user' => [
                    'name' => 'UKM Seni',
                    'username' => 'adminseni',
                    'password' => 'seni123',
                ],
                'ormawa' => [
                    'nama' => 'SENI',
                    'slug' => 'seni',
                    'logo' => 'images/logoseni.png',
                    'tipe_id' => $ukm->id,
                    'vision' => 'UKM Seni mewadahi mahasiswa di bidang seni musik, tari, dan kreativitas untuk mengekspresikan bakat dan mengembangkan potensi seni.',
                                ],
            ],
            [
                'user' => [
                    'name' => 'UKM Olahraga',
                    'username' => 'adminolahraga',
                    'password' => 'olahraga123',
                    'profile_photo_path' => null,
                ],
                'ormawa' => [
                    'nama' => 'OLAHRAGA',
                    'slug' => 'olahraga',
                    'logo' => 'images/logoolahraga.png',
                    'tipe_id' => $ukm->id,
                    'vision' => 'UKM Olahraga menaungi berbagai cabang olahraga seperti futsal, basket, voli, dan lainnya untuk membangun jiwa sportif dan sehat mahasiswa.',
                ],
            ],
            [
                'user' => [
                    'name' => 'MPM (Mahasiswa Pecinta Mushallah)',
                    'username' => 'adminmpm',
                    'password' => 'mpm123',
                    'profile_photo_path' => null,
                ],
                'ormawa' => [
                    'nama' => 'MPM',
                    'slug' => 'mpm',
                    'logo' => 'images/logompm.png',
                    'tipe_id' => $ukm->id,
                    'vision' => 'MPM adalah wadah bagi mahasiswa yang beragama islam.',

                ],
            ],
        ];

        foreach ($ormawaData as $data) {
            // Create user account
            $user = User::create([
                'name' => $data['user']['name'],
                'username' => $data['user']['username'],
                'password' => Hash::make($data['user']['password']),
                'role' => 'adminukm',
            ]);

            // Assign role (Spatie)
            $user->assignRole('adminukm');

            // Create ormawa linked to user
            Ormawa::create([
                'user_id' => $user->id,
                'nama' => $data['ormawa']['nama'],
                'slug' => $data['ormawa']['slug'],
                'logo' => $data['ormawa']['logo'],
                'tipe_ormawa_id' => $data['ormawa']['tipe_id'], // Menggunakan ID
                'vision' => $data['ormawa']['vision'], // Masuk ke vision
            ]);

            $this->command->info("✓ Created: {$data['ormawa']['nama']}");
        }

        // Cari user adminbem yang sudah dibuat oleh RolePermissionSeeder (biasanya ID 1)
        $adminBemUser = User::where('username', 'adminbem')->first();

        // Create BEM ormawa
        Ormawa::create([
            'user_id' => $adminBemUser ? $adminBemUser->id : null,
            'nama' => 'Badan Eksekutif Mahasiswa',
            'slug' => 'bem',
            'logo' => 'images/logobem.png',
            'tipe_ormawa_id' => $bem->id,
            'vision' => 'BEM ITH sebagai organisasi mahasiswa tingkat institut yang mewakili aspirasi seluruh mahasiswa.',
        ]);

        $this->command->info('✓ Created BEM ormawa');
    }
}