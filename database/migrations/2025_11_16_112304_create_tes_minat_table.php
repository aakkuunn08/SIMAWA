<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tes_minat', function (Blueprint $table) {
            $table->id('id_tes');
            $table->unsignedBigInteger('user_id')->nullable();      // siapa yang tes
            $table->unsignedBigInteger('id_jawaban')->nullable();   // bisa disesuaikan nanti
            $table->unsignedBigInteger('id_soal')->nullable();      // jika perlu
            $table->string('hasil_rekomendasi', 255)->nullable();   // jurusan/minat

            // FK ke tabel users
            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('set null');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tes_minat');
    }
};
