<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Ormawa;
use App\Models\User;

class OrmawaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create AdminUKM accounts with their ormawa information
        $ormawaData = [
            [
                'user' => [
                    'name' => 'HERO (Habibie Engineering Robotic of Organization)',
                    'username' => 'adminhero',
                    'password' => 'hero123',
                    'profile_photo_path' => null, // Will use default logo
                ],
                'ormawa' => [
                    'nama' => 'HERO',
                    'slug' => 'hero',
                    'logo' => 'images/logohero.png',
                    'tipe' => 'ukm',
                    'deskripsi' => 'UKM HERO bergerak di bidang robotik dan teknologi, mengembangkan inovasi dan prestasi mahasiswa ITH di bidang engineering dan robotika.',
                ],
            ],
            [
                'user' => [
                    'name' => 'HCC (Habibie Coding Club)',
                    'username' => 'adminhcc',
                    'password' => 'hcc123',
                    'profile_photo_path' => null,
                ],
                'ormawa' => [
                    'nama' => 'HCC',
                    'slug' => 'hcc',
                    'logo' => 'images/logohcc.png',
                    'tipe' => 'ukm',
                    'deskripsi' => 'Habibie Coding Club berfokus pada pengembangan software, coding, dan teknologi informasi untuk mempersiapkan mahasiswa menghadapi industri digital.',
                ],
            ],
            [
                'user' => [
                    'name' => 'UKM Seni',
                    'username' => 'adminseni',
                    'password' => 'seni123',
                    'profile_photo_path' => null,
                ],
                'ormawa' => [
                    'nama' => 'SENI',
                    'slug' => 'seni',
                    'logo' => 'images/logoseni.png',
                    'tipe' => 'ukm',
                    'deskripsi' => 'UKM Seni mewadahi mahasiswa di bidang seni musik, tari, dan kreativitas untuk mengekspresikan bakat dan mengembangkan potensi seni.',
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
                    'tipe' => 'ukm',
                    'deskripsi' => 'UKM Olahraga menaungi berbagai cabang olahraga seperti futsal, basket, voli, dan lainnya untuk membangun jiwa sportif dan sehat mahasiswa.',
                ],
            ],
            [
                'user' => [
                    'name' => 'MPM (Mahasiswa Pecinta Musik)',
                    'username' => 'adminmpm',
                    'password' => 'mpm123',
                    'profile_photo_path' => null,
                ],
                'ormawa' => [
                    'nama' => 'MPM',
                    'slug' => 'mpm',
                    'logo' => 'images/logompm.png',
                    'tipe' => 'ukm',
                    'deskripsi' => 'MPM adalah wadah bagi mahasiswa yang memiliki passion di bidang musik untuk berkarya dan mengembangkan talenta musikal.',
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
                'is_admin' => 0,
                'profile_photo_path' => $data['user']['profile_photo_path'],
            ]);

            // Assign role
            $user->assignRole('adminukm');

            // Create ormawa linked to user
            // Logo will use the default images since we don't have actual uploaded files in seeder
            Ormawa::create([
                'user_id' => $user->id,
                'nama' => $data['ormawa']['nama'],
                'slug' => $data['ormawa']['slug'],
                'logo' => $data['ormawa']['logo'], // Using default logo from public/images
                'tipe' => $data['ormawa']['tipe'],
                'deskripsi' => $data['ormawa']['deskripsi'],
            ]);

            $this->command->info("✓ Created account and ormawa: {$data['user']['username']} / {$data['ormawa']['nama']}");
        }

        // Create BEM ormawa (without user account - managed by adminbem)
        Ormawa::create([
            'user_id' => null,
            'nama' => 'Badan Eksekutif Mahasiswa',
            'slug' => 'bem',
            'logo' => 'images/logobem.png',
            'tipe' => 'bem',
            'deskripsi' => 'BEM ITH sebagai organisasi mahasiswa tingkat institut yang mewakili aspirasi dan kepentingan seluruh mahasiswa.',
        ]);

        $this->command->info('✓ Created BEM ormawa');
        $this->command->info('');
        $this->command->info('===========================================');
        $this->command->info('Dummy Accounts Created:');
        $this->command->info('===========================================');
        foreach ($ormawaData as $data) {
            $this->command->info("Username: {$data['user']['username']} | Password: {$data['user']['password']}");
        }
        $this->command->info('===========================================');
    }
}
