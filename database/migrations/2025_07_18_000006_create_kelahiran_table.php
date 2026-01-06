<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kelahiran', function (Blueprint $table) {
            $table->id();
            $table->string('nik')->nullable();
            $table->enum('jenis_kelamin', ['L','P'])->nullable();
            // $table->string('tempat_lahir');
            // $table->date('tanggal_lahir')->nullable();
            // $table->string('alamat')->nullable();
            // $table->string('kewarganegaraan')->nullable();
            // $table->foreignId('banjar_id')->nullable()->constrained('banjar')->nullOnDelete();
            $table->foreignId('kk_tujuan_id')->constrained('kks')->cascadeOnDelete();
            $table->text('keterangan')->nullable();
            $table->foreignId('penduduk_id')->constrained('penduduk')->cascadeOnDelete();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('kelahiran');
    }
};
