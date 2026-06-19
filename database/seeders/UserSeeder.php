<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
                'phone' => '081234567890',
                'address' => 'Jl. Admin No. 1, Jakarta',
            ]
        );

        User::updateOrCreate(
            ['email' => 'buyer@test.com'],
            [
                'name' => 'Pembeli Contoh',
                'password' => Hash::make('password'),
                'role' => 'pembeli',
                'email_verified_at' => now(),
                'phone' => '089876543210',
                'address' => 'Jl. Pembeli No. 10, Bandung',
            ]
        );
    }
}
