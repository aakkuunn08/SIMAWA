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
            $table->string('whatsapp')->nullable(); //untuk menyimpan nomor wa
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ormawa', function (Blueprint $table) {
            //
        });
    }
};
