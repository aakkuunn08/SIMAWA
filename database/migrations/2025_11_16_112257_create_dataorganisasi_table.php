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
            $table->id('id_organisasi');
            $table->unsignedBigInteger('user_id');     // siapa yang input
            $table->string('kode_kepengurusan', 100)->nullable();
            $table->string('nama_organisasi', 200);
            $table->text('deskripsi_organisasi')->nullable();
            $table->string('email', 100)->nullable();
            $table->string('whatsapp', 20)->nullable();

            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dataorganisasi');
    }
};
