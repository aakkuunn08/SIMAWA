<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKategoriToSoalTable extends Migration
{
    public function up(): void
    {
        Schema::table('soal', function (Blueprint $table) {
            $table->string('kategori')->after('skala_likert'); // Kolom kategori untuk membedakan UKM target
        });
    }

    public function down(): void
    {
        Schema::table('soal', function (Blueprint $table) {
            $table->dropColumn('kategori');
        });
    }
}
