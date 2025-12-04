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
        Schema::table('daftar_kegiatan', function (Blueprint $table) {
            $table->string('tempat', 200)->nullable()->after('tanggal_kegiatan');
            $table->time('waktu_mulai')->nullable()->after('tempat');
            $table->time('waktu_selesai')->nullable()->after('waktu_mulai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('daftar_kegiatan', function (Blueprint $table) {
            $table->dropColumn(['tempat', 'waktu_mulai', 'waktu_selesai']);
        });
    }
};
