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
        Schema::create('ormawa', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke tabel users (Wajib ada supaya akun & ormawa nyambung)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Relasi ke tabel tipe_ormawas (Tiang penyangga yang tadi error)
            $table->foreignId('tipe_ormawa_id')->nullable()->constrained('tipe_ormawas')->onDelete('set null');

            $table->string('nama');
            $table->string('slug')->unique();
            $table->string('logo')->nullable();
            
            // Tambahkan kolom visi, mission, structure agar modelnya tidak error nanti
            $table->text('vision')->nullable();
            $table->text('mission')->nullable();
            $table->text('structure')->nullable(); // Disimpan sebagai JSON/Array

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ormawa');
    }
};
