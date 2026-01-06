<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kematian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penduduk_id')->nullable()->constrained('penduduk')->nullOnDelete();
            $table->string('nama');
            $table->string('nik')->nullable();
            $table->string('no_kk')->nullable();
            $table->date('tanggal_kematian')->nullable();
            $table->foreignId('banjar_id')->nullable()->constrained('banjar')->nullOnDelete();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('kematian');
    }
};
