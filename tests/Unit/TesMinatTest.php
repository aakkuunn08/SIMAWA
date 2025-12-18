<?php
namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Jawaban;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TesMinatTest extends TestCase
{
    use RefreshDatabase;

    // 13. Penyimpanan Hasil Tes Minat
    public function test_hasil_tes_minat_tersimpan_ke_database()
    {
        // Seed ormawa data if needed
        \App\Models\Ormawa::create([
            'nama' => 'HERO',
            'tipe' => 'ukm',
            'deskripsi' => 'Unit Robotika',
            'logo' => 'logo.png',
            'slug' => 'hero'
        ]);

        $dataTes = [
            'nama_lengkap' => 'John Doe',
            'nim' => '231031001',
            'program_studi' => 'Teknik Informatika',
            'angkatan' => 2023,
            'q1' => 4,
            'q2' => 3,
            'q3' => 5,
            'q4' => 2,
            'q5' => 4,
            'q6' => 5,
        ];
        $this->post('/tesminat/submit', $dataTes);
        $this->assertDatabaseHas('tes_minat', [
            'nama_lengkap' => 'John Doe',
            'nim' => '231031001',
        ]);
    }

    // 14. Validasi Biodata NIM
    public function test_submit_gagal_jika_nim_kosong()
    {
        $response = $this->post('/tesminat/submit', [
            'nama_lengkap' => 'John Doe',
            'nim' => '',
            'program_studi' => 'Teknik Informatika',
            'angkatan' => 2023,
            'q1' => 4,
        ]);
        $response->assertSessionHasErrors('nim');
    }

    // 15. Validasi Biodata Nama Lengkap
    public function test_submit_gagal_jika_nama_lengkap_kosong()
    {
        $response = $this->post('/tesminat/submit', [
            'nama_lengkap' => '',
            'nim' => '231031001',
            'program_studi' => 'Teknik Informatika',
            'angkatan' => 2023,
            'q1' => 4,
        ]);
        $response->assertSessionHasErrors('nama_lengkap');
    }
}
?>