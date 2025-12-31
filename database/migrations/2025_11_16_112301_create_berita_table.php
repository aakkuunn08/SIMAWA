<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('berita', function (Blueprint $table) {
            $table->id('id_berita');
            $table->unsignedBigInteger('user_id'); 
            $table->string('judul_berita', 255);
            $table->text('konten'); 
            $table->date('tanggal_publikasi')->nullable();
            $table->string('gambar', 255)->nullable();
            $table->boolean('published')->default(true); // CUKUP SATU SAJA DI SINI
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('berita');
    }
};