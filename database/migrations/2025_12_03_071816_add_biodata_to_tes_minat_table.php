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
        Schema::table('tes_minat', function (Blueprint $table) {
            $table->string('nama_lengkap')->nullable()->after('user_id');
            $table->string('nim')->nullable()->after('nama_lengkap');
            $table->string('program_studi')->nullable()->after('nim');
            $table->string('angkatan')->nullable()->after('program_studi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tes_minat', function (Blueprint $table) {
            $table->dropColumn(['nama_lengkap', 'nim', 'program_studi', 'angkatan']);
        });
    }
};
