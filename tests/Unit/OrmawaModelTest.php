<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Ormawa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrmawaModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test 1: Test relasi Ormawa belongsTo User
     * 
     * @return void
     */
    public function test_ormawa_belongs_to_user()
    {
        // Arrange: Buat user dan ormawa
        $user = User::factory()->create();
        $ormawa = Ormawa::create([
            'user_id' => $user->id,
            'nama' => 'HERO ITH',
            'slug' => 'hero',
            'logo' => 'images/logohero.png',
            'tipe' => 'ukm',
            'deskripsi' => 'Unit Kegiatan Mahasiswa Robotika',
        ]);

        // Act: Ambil relasi user dari ormawa
        $relatedUser = $ormawa->user;

        // Assert: Pastikan relasi benar
        $this->assertInstanceOf(User::class, $relatedUser);
        $this->assertEquals($user->id, $relatedUser->id);
        $this->assertEquals($user->name, $relatedUser->name);
    }

    /**
     * Test 2: Test fillable attributes pada Model Ormawa
     * 
     * @return void
     */
    public function test_ormawa_fillable_attributes()
    {
        // Arrange: Data ormawa
        $data = [
            'user_id' => 1,
            'nama' => 'HCC ITH',
            'slug' => 'hcc',
            'logo' => 'images/logohcc.png',
            'tipe' => 'ukm',
            'deskripsi' => 'Unit Kegiatan Mahasiswa Komputer',
        ];

        // Act: Buat ormawa dengan mass assignment
        $ormawa = new Ormawa($data);

        // Assert: Pastikan semua attribute terisi
        $this->assertEquals($data['user_id'], $ormawa->user_id);
        $this->assertEquals($data['nama'], $ormawa->nama);
        $this->assertEquals($data['slug'], $ormawa->slug);
        $this->assertEquals($data['logo'], $ormawa->logo);
        $this->assertEquals($data['tipe'], $ormawa->tipe);
        $this->assertEquals($data['deskripsi'], $ormawa->deskripsi);
    }

    /**
     * Test 3: Test pembuatan Ormawa dengan tipe BEM
     * 
     * @return void
     */
    public function test_create_ormawa_with_bem_type()
    {
        // Arrange & Act: Buat ormawa BEM
        $ormawa = Ormawa::create([
            'nama' => 'Badan Eksekutif Mahasiswa',
            'slug' => 'bem',
            'logo' => 'images/logobem.png',
            'tipe' => 'bem',
            'deskripsi' => 'BEM ITH sebagai organisasi mahasiswa tingkat institut',
        ]);

        // Assert: Pastikan data tersimpan dengan benar
        $this->assertDatabaseHas('ormawa', [
            'nama' => 'Badan Eksekutif Mahasiswa',
            'slug' => 'bem',
            'tipe' => 'bem',
        ]);
        $this->assertEquals('bem', $ormawa->tipe);
    }
}
