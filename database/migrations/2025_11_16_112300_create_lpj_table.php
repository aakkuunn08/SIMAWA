<?php

use App\Models\Lpj;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLpjTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lpj', function (Blueprint $table) {
            $table->id('id_lpj');
            $table->unsignedBigInteger('id_kegiatan');
            $table->string('file_lpj', 255);
            $table->date('tanggal_upload');
            $table->string('status_lpj', 50);

            $table->foreign('id_kegiatan')
                  ->references('id_kegiatan')->on('daftar_kegiatan')
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lpj');
    }
    
    public function lpj()
    {
        // Asumsi: satu kegiatan hanya punya satu file LPJ
        return $this->hasOne(Lpj::class, 'kegiatan_id', 'id_kegiatan');
    }
}
