<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AutentikasiTest extends TestCase 
{
    use RefreshDatabase;

    // 1. Validasi Login Admin
    public function test_login_menolak_password_salah()
    {
        $user = User::factory()->create(['password' => bcrypt('password123')]);
        $response = $this->post('/login', [
            'name' => 'Admin Test', // Tambahkan name
            'username' => $user->username,
            'password' => 'salah-password',
        ]);
        $response->assertSessionHasErrors();
        $this->assertGuest();
    }

    // 2. Pengecekan Role Pengguna
    public function test_admin_ukm_tidak_bisa_akses_menu_admin_bem()
    {
        $adminUkm = User::factory()->create(['name' => 'UKM User','role' => 'adminukm']);
        $response = $this->actingAs($adminUkm)->get('/adminbem/accounts');
        $response->assertStatus(403);
    }

    // 3. Logout Session
    public function test_logout_menghapus_session()
    {
        $user = User::factory()->create();
        $this->actingAs($user)->post('/logout');
        $this->assertGuest();
    }

    // 4. Hash Password
    public function test_password_tersimpan_dalam_bentuk_hash()
    {
        $password = 'secret123';
        $user = User::create([
            'username' => 'ukm_test',
            'name' => 'UKM Test', // Tambahkan 'name' agar tidak error Field 'name' doesn't have a default value
            'password' => bcrypt($password),
            'role' => 'adminukm'
        ]);
        $this->assertNotEquals($password, $user->password);
        $this->assertTrue(Hash::check($password, $user->password));
    }

    // 5. Validasi Duplikasi Username
    public function test_username_harus_unique()
    {
        // 1. Buat satu user dulu agar username 'ukm_robotik' terpakai
        User::create([
            'name' => 'User Eksis',
            'username' => 'ukm_robotik',
            'password' => bcrypt('password123'),
            'role' => 'adminukm'
        ]);

        // 2. Buat user adminbem untuk auth
        $adminBem = User::factory()->create(['role' => 'adminbem']);

        // 3. Coba kirim data dengan username yang sama ke route STORE
        // Gunakan URL 'adminbem/accounts' sesuai hasil route:list POST kamu
        $response = $this->actingAs($adminBem)->post('adminbem/accounts', [
            'name' => 'User Baru',
            'username' => 'ukm_robotik', // Duplikat
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        // 4. Pastikan sistem memberikan error pada field username
        $response->assertSessionHasErrors('username');
    }
}