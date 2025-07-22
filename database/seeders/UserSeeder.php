<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678'),
            'perfil' => 'Admin'
        ]);

        User::create([
            'name' => 'usuario',
            'email' => 'user@gmail.com',
            'password' => bcrypt('12345678'),
            'perfil' => 'Usuario'
        ]);

        User::create([
            'name' => 'usuario1',
            'email' => 'usuario@gmail.com',
            'password' => bcrypt('12345678'),
            'perfil' => 'Usuario'
        ]);
    }
}
