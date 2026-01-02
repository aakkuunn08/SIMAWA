<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Seed Roles & Permissions first
        $this->call([
            RolePermissionSeeder::class,
        ]);

        // Buat user AdminBEM (Super Admin) - HANYA untuk setup awal
        $adminBem = User::create([
            'name' => 'Admin BEM',
            'username' => 'adminbem',
            'password' => Hash::make('adminbem123'), // Ganti dengan password yang aman di production
            'role' => 'adminbem', // Keep for backward compatibility
            'is_admin' => 1,
        ]);
        // Assign Spatie role
        $adminBem->assignRole('adminbem');

        $this->command->info('✓ AdminBEM user created successfully!');
        $this->command->info('  Username: adminbem');
        $this->command->info('  Password: adminbem123');
        $this->command->warn('  ⚠ IMPORTANT: Change this password in production!');

        // Panggil OrmawaSeeder dan SoalSeeder
        $this->call([
            OrmawaSeeder::class,
            SoalSeeder::class,
            DaftarKegiatanSeeder::class, // <--- TAMBAHKAN INI
        ]);
        
        // Panggil BeritaSeeder
        $this->call([
            BeritaSeeder::class,
        ]);
        
        // $this->command->info('');
        // $this->command->info('===========================================');
        // $this->command->info('Database seeding completed successfully!');
        // $this->command->info('===========================================');
        // $this->command->info('Next steps:');
        // $this->command->info('1. Login as AdminBEM (adminbem/adminbem123)');
        // $this->command->info('2. Create other admin users via UI');
        // $this->command->info('3. All users will be stored in database');
        // $this->command->info('===========================================');
    }
}
