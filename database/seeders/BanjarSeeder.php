<?php

namespace Database\Seeders;

use Illuminate\Container\Attributes\Database;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Banjar;

class BanjarSeeder extends Seeder
{
    public function run(): void
    {
        $banjars = [
            'Banjar Tebesaya',
            'Banjar Ambengan',
            'Banjar Pande',
            'Banjar Teruna',
            'Banjar Tengah Kauh',
            'Banjar Tengah Kangin',
            'Banjar Kalah',
            'Banjar Teges Kawan',
            'Banjar Yangloni',
            'Banjar Teges Kanginan',
        ];

        foreach ($banjars as $nama) {
            Banjar::updateOrCreate(
                ['nama' => $nama]
            );
        }
    }
}

// class BanjarSeeder extends Seeder
// {
//     /**
//      * Run the database seeds.
//      */
//     public function run(): void
//     {
//         DB::table('banjar')->insert([
//             ['nama' => 'Banjar Tebesaya'],
//             ['nama' => 'Banjar Ambengan'],
//             ['nama' => 'Banjar Pande'],
//             ['nama' => 'Banjar Teruna'],
//             ['nama' => 'Banjar Tengah Kauh'],
//             ['nama' => 'Banjar Tengah Kangin'],
//             ['nama' => 'Banjar Kalah'],
//             ['nama' => 'Banjar Teges Kawan'],
//             ['nama' => 'Banjar Yangloni'],
//             ['nama' => 'Banjar Teges Kanginan'],
//         ]);
//     }
// }
