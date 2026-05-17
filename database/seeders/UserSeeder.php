<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Tạo tài khoản Admin
        User::create([
            'name'              => 'Admin',
            'email'             => 'admin@travelguide.com',
            'password'          => Hash::make('password'),
            'role'              => 'admin',
            'is_active'         => true,
            'email_verified_at' => now(),
        ]);

        // Tạo 5 user thường
        $users = [
            ['name' => 'Nguyễn Văn An', 'email' => 'an@example.com'],
            ['name' => 'Trần Thị Bình', 'email' => 'binh@example.com'],
            ['name' => 'Lê Văn Cường', 'email' => 'cuong@example.com'],
            ['name' => 'Phạm Thị Dung', 'email' => 'dung@example.com'],
            ['name' => 'Hoàng Văn Em', 'email' => 'em@example.com'],
        ];

        foreach ($users as $userData) {
            User::create([
                'name'              => $userData['name'],
                'email'             => $userData['email'],
                'password'          => Hash::make('password'),
                'role'              => 'user',
                'is_active'         => true,
                'email_verified_at' => now(),
            ]);
        }
    }
}
