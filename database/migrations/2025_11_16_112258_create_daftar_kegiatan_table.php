<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDaftarKegiatanTable extends Migration
{
    public function up(): void
    {
        Schema::create('daftar_kegiatan', function (Blueprint $table) {
            $table->id('id_kegiatan');
            $table->unsignedBigInteger('id_akun');
            $table->string('nama_kegiatan', 200);
            $table->date('tanggal_kegiatan');
            $table->string('status_kegiatan', 50);

            $table->foreign('id_akun')
                  ->references('id')->on('akun')   // atau 'users' kalau pakai users
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daftar_kegiatan');
    }
}
