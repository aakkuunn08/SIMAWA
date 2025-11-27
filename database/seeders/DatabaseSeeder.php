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

        // Buat user AdminBEM (Super Admin)
        User::create([
            'name' => 'Admin BEM',
            'username' => 'adminbem',
            'password' => Hash::make('adminbem123'), // Ganti dengan password yang aman
            'role' => 'adminbem',
            'is_admin' => 1,
        ]);

        // Buat user Admin (Admin Biasa)
        User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'password' => Hash::make('admin123'), // Ganti dengan password yang aman
            'role' => 'admin',
            'is_admin' => 1,
        ]);

        // Panggil OrmawaSeeder
        $this->call([
            OrmawaSeeder::class,
        ]);
    }
}
