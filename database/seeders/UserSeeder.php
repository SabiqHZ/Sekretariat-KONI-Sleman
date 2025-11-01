<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrasi',
            'password' => Hash::make('admin12345'),
            'role' => 'administrasi',
        ]);

        User::create([
            'name' => 'Admin Keuangan',
            'password' => Hash::make('keuangan12345'),
            'role' => 'keuangan',
        ]);

        User::create([
            'name' => 'Admin Aset',
            'password' => Hash::make('aset12345'),
            'role' => 'aset',
        ]);

        User::create([
            'name' => 'Supervisor',
            'password' => Hash::make('supervisor12345'),
            'role' => 'supervisor',
        ]);
    }
}
