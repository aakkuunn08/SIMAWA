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
        Schema::table('lpj', function (Blueprint $table) {
            // Kita tambah kolom baru di sini
            $table->string('nama_lpj')->nullable()->after('file_lpj');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lpj', function (Blueprint $table) {
            // Ini perintah buat hapus kalau migrasinya dibatalkan (rollback)
            $table->dropColumn('nama_lpj');
        });
    }
};