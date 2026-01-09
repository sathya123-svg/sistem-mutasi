<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    
    public function run()
    
    {
        
        // SUPER ADMIN
        User::create([
            'name' => 'superadmin',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('password123'),
            'role' => 'superadmin',
            'banjar_id' => null
        ]);

        // ADMIN BANJAR 1
        User::create([
            'name' => 'Banjar Tebesaya',
            'email' => 'admin1@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'banjar_id' => 1
        ]);

        // ADMIN BANJAR 2 (opsional)
        User::create([
            'name' => 'Admin Banjar Kaja',
            'email' => 'admin2@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'banjar_id' => 2
        ]);
    }
}
