<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendudukTable extends Migration
{
    public function up()
    {
        Schema::create('penduduk', function (Blueprint $table) {
            $table->id();

            // Data Identitas
            $table->string('nama');
            $table->string('nik')->nullable()->unique();
            $table->string('jenis_kelamin', 1); // L / P
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('alamat')->nullable();
            // $table->string('banjar')->nullable();
            $table->string('kewarganegaraan')->nullable();

            // Relasi ke KK (boleh null)
            $table->unsignedBigInteger('kk_id')->nullable();
            $table->foreign('kk_id')->references('id')->on('kks')->nullOnDelete();

            // Relasi ke banjar
            $table->unsignedBigInteger('banjar_id')->nullable();
            $table->foreign('banjar_id')->references('id')->on('banjar')->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('penduduk');
    }
}
