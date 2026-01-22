<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('mutasi_keluar', function (Blueprint $table) {
    $table->id();
    $table->string('nama');
    $table->string('nik');
    $table->string('nomor_kk')->nullable();
    $table->date('tanggal_keluar');
    $table->string('alasan');
    $table->string('tujuan_daerah')->nullable();
    $table->unsignedBigInteger('banjar_id');
    $table->timestamps();
});

    }
    public function down(): void
    {
        Schema::dropIfExists('mutasi_keluar');
    }
};