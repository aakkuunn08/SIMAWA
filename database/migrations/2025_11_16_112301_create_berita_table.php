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
            $table->string('judul_berita', 255);
            $table->string('url_sumber', 255)->nullable();
            $table->date('tanggal_publikasi')->nullable();
            $table->string('gambar', 255)->nullable();
            $table->string('sumber', 150)->nullable();

            $table->unsignedBigInteger('user_id'); // user yang input berita

            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('berita');
    }
};
