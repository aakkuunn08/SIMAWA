<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LpjTest extends TestCase
{
    use RefreshDatabase;

    // 10. Validasi Tipe File
    public function test_upload_lpj_hanya_menerima_pdf_docx()
    {
        Storage::fake('public');
        $admin = \App\Models\User::factory()->create(['role' => 'adminbem']);
        $kegiatan = \App\Models\DaftarKegiatan::factory()->create();
        $file = UploadedFile::fake()->create('dokumen.txt', 100);
        $response = $this->actingAs($admin)->post("/kegiatan/{$kegiatan->id_kegiatan}/upload-lpj", ['file_lpj' => $file]);
        $response->assertSessionHasErrors('file_lpj');
    }

    // 11. Batas Ukuran File
    public function test_upload_lpj_maksimal_ukuran_file()
    {
        Storage::fake('public');
        $admin = \App\Models\User::factory()->create(['role' => 'adminbem']);
        $kegiatan = \App\Models\DaftarKegiatan::factory()->create();
        $file = UploadedFile::fake()->create('lpj_besar.pdf', 10000); // 10MB
        $response = $this->actingAs($admin)->post("/kegiatan/{$kegiatan->id_kegiatan}/upload-lpj", ['file_lpj' => $file]);
        $response->assertSessionHasErrors('file_lpj');
    }

    // 12. Integrasi Simpan File
    public function test_file_lpj_tersimpan_di_direktori_server()
    {
        Storage::fake('public');
        $admin = \App\Models\User::factory()->create(['role' => 'adminbem']);
        $kegiatan = \App\Models\DaftarKegiatan::factory()->create();
        $file = UploadedFile::fake()->create('lpj_real.pdf', 500);
        $response = $this->actingAs($admin)->post("/kegiatan/{$kegiatan->id_kegiatan}/upload-lpj", ['file_lpj' => $file]);
        $path = $response->json()['path'];
        Storage::disk('public')->assertExists($path);
    }
}
?>
