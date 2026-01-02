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
        Schema::table('ormawa', function (Blueprint $table) {
            // Tambahkan kolom untuk menampung data dinamis
            $table->text('vision')->nullable();
            $table->text('mission')->nullable();
            $table->text('structure')->nullable(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ormawa', function (Blueprint $table) {
            // Hapus kolom jika migrasi di-rollback
            $table->dropColumn(['vision', 'mission', 'structure']);
        });
    }
};