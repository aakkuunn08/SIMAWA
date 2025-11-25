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

            // Kolom tambahan
            $table->string('nama');         // HERO, HCC, SENI, OLAHRAGA, dll
            $table->string('slug')->unique(); // hero, hcc, seni, olahraga, bem
            $table->string('logo')->nullable(); // path logo
            $table->string('tipe')->nullable(); // ukm / bem / komunitas
            $table->text('deskripsi')->nullable(); // deskripsi detail

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
