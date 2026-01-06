<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pendatang', function (Blueprint $table) {
            $table->id();
            // $table->string('nama');
            // $table->string('nik')->nullable();
            $table->foreignId('penduduk_id')->constrained('penduduk')->cascadeOnDelete();
            $table->string('no_kk')->nullable();
            $table->string('asal')->nullable();
            $table->foreignId('kk_tujuan_id')->nullable()->constrained('kks')->nullOnDelete();
            $table->foreignId('banjar_id')->nullable()->constrained('banjar')->nullOnDelete();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('pendatang');
    }
};
