<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
    Schema::create('perkawinan', function (Blueprint $table) {
        $table->id();

        // relasi (opsional, histori)
        $table->foreignId('penduduk_id')
            ->nullable()
            ->constrained('penduduk')
            ->nullOnDelete(); // ⬅️ PENTING

        // 🔥 SNAPSHOT DATA (WAJIB)
        $table->string('nama');
        $table->string('nik');
        $table->string('nomor_kk')->nullable();

        // 🔥 FILTER ADMIN PER BANJAR
        $table->foreignId('banjar_id')
            ->constrained('banjars')
            ->restrictOnDelete();

        // KK tujuan (jika masuk)
        $table->foreignId('kk_tujuan_id')
            ->nullable()
            ->constrained('kks')
            ->nullOnDelete();

        $table->enum('tipe', ['masuk', 'keluar']);
        $table->date('tanggal');
        $table->text('keterangan')->nullable();

        $table->timestamps();
    });

    }

    public function down(): void
    {
        Schema::dropIfExists('perkawinan');
    }
};
