<?php
namespace Tests\Unit;

use Tests\TestCase;
use App\Models\DaftarKegiatan;
use Illuminate\Foundation\Testing\RefreshDatabase;

class KegiatanTest extends TestCase
{
    use RefreshDatabase;

    // 6. Validasi Format Tanggal
    public function test_simpan_kegiatan_format_tanggal_salah()
    {
        $admin = \App\Models\User::factory()->create(['role' => 'adminbem']);
        $response = $this->actingAs($admin)->post('/kegiatan', [
            'nama_kegiatan' => 'Seminar Teknologi',
            'tanggal_kegiatan' => 'invalid-date',
            'tempat' => 'Tempat',
            'waktu_mulai' => '10:00',
            'waktu_selesai' => '12:00',
        ]);
        $response->assertSessionHasErrors('tanggal_kegiatan');
    }

    // 7. Input Nama Kegiatan Kosong
    public function test_nama_kegiatan_tidak_boleh_kosong()
    {
        $admin = \App\Models\User::factory()->create(['role' => 'adminbem']);
        $response = $this->actingAs($admin)->post('/kegiatan', [
            'nama_kegiatan' => '',
            'tanggal_kegiatan' => '2025-11-13',
            'tempat' => 'Tempat',
            'waktu_mulai' => '10:00',
            'waktu_selesai' => '12:00',
        ]);
        $response->assertSessionHasErrors('nama_kegiatan');
    }

    // 8. Update Data Kegiatan (Fungsi edit())
    public function test_edit_kegiatan_berhasil_di_database()
    {
        $admin = \App\Models\User::factory()->create(['role' => 'adminbem']);
        $kegiatan = DaftarKegiatan::factory()->create(['nama_kegiatan' => 'Lama']);
        $this->actingAs($admin)->put("/kegiatan/{$kegiatan->id_kegiatan}", [
            'nama_kegiatan' => 'Baru',
            'tanggal_kegiatan' => '2025-11-14',
            'tempat' => 'Tempat Baru',
            'waktu_mulai' => '10:00',
            'waktu_selesai' => '12:00',
        ]);
        $this->assertDatabaseHas('daftar_kegiatan', ['nama_kegiatan' => 'Baru']);
    }

    // 9. Hapus Kegiatan
    public function test_hapus_kegiatan_berhasil()
    {
        $admin = \App\Models\User::factory()->create(['role' => 'adminbem']);
        $kegiatan = DaftarKegiatan::factory()->create();
        $this->actingAs($admin)->delete("/kegiatan/{$kegiatan->id_kegiatan}");
        $this->assertDatabaseMissing('daftar_kegiatan', ['id_kegiatan' => $kegiatan->id_kegiatan]);
    }
}
?>