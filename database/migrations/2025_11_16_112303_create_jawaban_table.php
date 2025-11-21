<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJawabanTable extends Migration
{
    public function up(): void
    {
        Schema::create('jawaban', function (Blueprint $table) {
            $table->id('id_jawaban');
            $table->unsignedBigInteger('id_soal');
            $table->string('nama', 150);
            $table->string('nim', 20);
            $table->date('tanggal_pengisian');
            $table->integer('jawaban_tes');   // nilai likert utk soal ini
            $table->integer('skor_total')->nullable();

            $table->foreign('id_soal')
                  ->references('id_soal')->on('soal')
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jawaban');
    }
}
