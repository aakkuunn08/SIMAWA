<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dataorganisasi', function (Blueprint $table) {
            $table->id('id_kegiatan');
            $table->unsignedBigInteger('akun_id');     // siapa yang input
            $table->string('nama_kegiatan', 200);
            $table->date('tanggal_kegiatan');
            $table->string('status_kegiatan', 50);

            $table->foreign('akun_id')
                  ->references('id')->on('akun')        // PK tabel akun = id
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daftar_kegiatan');
    }
};
