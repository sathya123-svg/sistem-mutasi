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
    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email')->unique();
        $table->string('password');

        // role superadmin & admin banjar
        $table->enum('role', ['superadmin', 'admin']);

        // foreign key ke tabel banjar
        $table->foreignId('banjar_id')
            ->nullable()
            ->constrained('banjar')
            ->nullOnDelete(); // lebih clean daripada onDelete('set null')

        $table->rememberToken();
        $table->timestamps();
    });
}



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
