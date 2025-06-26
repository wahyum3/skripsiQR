<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'id_pegawai' => 'ADM01',
            'nama' => 'Admin',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'id_pegawai' => 'USR01',
            'nama' => 'User Satu',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);
    }
}
