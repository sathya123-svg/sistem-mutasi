<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kks', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_kk')->unique();

            // kepala keluarga = penduduk.id (boleh null)
            // $table->unsignedBigInteger('kepala_keluarga')->nullable();

            $table->unsignedBigInteger('banjar_id')->nullable();

            $table->unsignedBigInteger('kepala_keluarga')
                ->references('id')
                ->on('penduduk')
                ->nullOnDelete();

            $table->foreign('banjar_id')
                ->references('id')
                ->on('banjar')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kks');
    }
};
