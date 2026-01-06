<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('perkawinan', function (Blueprint $table) {
            $table->id();

            // Penduduk yang menikah
            $table->foreignId('penduduk_id')
                  ->constrained('penduduk')
                  ->cascadeOnDelete();

            // KK tujuan (jika masuk)
            $table->foreignId('kk_tujuan_id')
                  ->nullable()
                  ->constrained('kks')
                  ->nullOnDelete();

            // Masuk / Keluar
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
