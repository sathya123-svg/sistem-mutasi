<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        // Jalankan semua seeder
        $this->call([
            BanjarSeeder::class,
            PendudukSeeder::class,
            UserSeeder::class,       // <--- ini yang penting
        ]);
    }
}
