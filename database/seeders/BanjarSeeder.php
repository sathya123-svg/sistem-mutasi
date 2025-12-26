<?php

namespace Database\Seeders;

use Illuminate\Container\Attributes\Database;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BanjarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('banjar')->insert([
            ['nama' => 'Banjar Tebesaya'],
            ['nama' => 'Banjar Ambengan'],
            ['nama' => 'Banjar Pande'],
            ['nama' => 'Banjar Teruna'],
            ['nama' => 'Banjar Tengah Kauh'],
            ['nama' => 'Banjar Tengah Kangin'],
            ['nama' => 'Banjar Kalah'],
            ['nama' => 'Banjar Teges Kawan'],
            ['nama' => 'Banjar Yangloni'],
            ['nama' => 'Banjar Teges Kanginan'],
        ]);
    }
}
