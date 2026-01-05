<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLpjTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lpj', function (Blueprint $table) {
            $table->id('id_lpj');
            
            // Foreign Key ke tabel kegiatan
            $table->unsignedBigInteger('id_kegiatan');
            
            // Kolom gabungan dari file migrasi yang mau dihapus
            $table->string('nama_lpj')->nullable(); 
            $table->date('deadline')->nullable(); 
            
            $table->string('file_lpj', 255)->nullable(); 
            $table->date('tanggal_upload')->nullable(); 
            
            $table->enum('status_lpj', ['Pending', 'Revisi', 'Diterima'])->default('pending');
            $table->text('catatan_revisi')->nullable(); // Untuk pesan dari BEM kenapa direvisi

            $table->timestamps();

            // Definisi Foreign Key
            $table->foreign('id_kegiatan')
                  ->references('id_kegiatan')->on('daftar_kegiatan')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lpj');
    }
}