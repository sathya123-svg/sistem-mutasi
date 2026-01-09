<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // SUPER ADMIN
        User::updateOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'name' => 'superadmin',
                'password' => Hash::make('password123'),
                'role' => 'superadmin',
                'banjar_id' => null,
            ]
        );

        // ADMIN BANJAR 1
        User::updateOrCreate(
            ['email' => 'admin1@example.com'],
            [
                'name' => 'Banjar Tebesaya',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'banjar_id' => 1,
            ]
        );

        // ADMIN BANJAR 2
        User::updateOrCreate(
            ['email' => 'admin2@example.com'],
            [
                'name' => 'Admin Banjar Kaja',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'banjar_id' => 2,
            ]
        );
    }
}

// class UserSeeder extends Seeder
// {
    
//     public function run()
    
//     {
        
//         // SUPER ADMIN
//         User::create([
//             'name' => 'superadmin',
//             'email' => 'superadmin@example.com',
//             'password' => Hash::make('password123'),
//             'role' => 'superadmin',
//             'banjar_id' => null
//         ]);

//         // ADMIN BANJAR 1
//         User::create([
//             'name' => 'Banjar Tebesaya',
//             'email' => 'admin1@example.com',
//             'password' => Hash::make('password123'),
//             'role' => 'admin',
//             'banjar_id' => 1
//         ]);

//         // ADMIN BANJAR 2 (opsional)
//         User::create([
//             'name' => 'Admin Banjar Kaja',
//             'email' => 'admin2@example.com',
//             'password' => Hash::make('password123'),
//             'role' => 'admin',
//             'banjar_id' => 2
//         ]);
//     }
// }
