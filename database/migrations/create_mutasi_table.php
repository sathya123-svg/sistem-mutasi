<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up()
{
    Schema::create('mutasi', function (Blueprint $table) {
        $table->id();
        $table->foreignId('penduduk_id')->constrained('penduduk')->onDelete('cascade');
        $table->enum('jenis_mutasi', ['Pindah Domisili', 'Meninggal', 'Kawin Keluar']);
        $table->date('tanggal');
        $table->text('keterangan')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mutasi');
    }
};
