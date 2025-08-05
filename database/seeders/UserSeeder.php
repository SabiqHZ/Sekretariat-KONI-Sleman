<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
                DB::table('users')->insert([
            [
                'name' => 'Administrasi',
                'email' => 'administrasi@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'administrasi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Admin Keuangan',
                'email' => 'keuangan@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'keuangan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Admin Aset',
                'email' => 'aset@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'aset',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
