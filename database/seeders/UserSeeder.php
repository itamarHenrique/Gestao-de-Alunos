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
            'perfil' => 'admin'
        ]);

        User::create([
            'name' => 'usuario',
            'email' => 'user@gmail.com',
            'password' => bcrypt('12345678'),
            'perfil' => 'usuario'
        ]);

        User::create([
            'name' => 'usuario1',
            'email' => 'usuario@gmail.com',
            'password' => bcrypt('12345678'),
            'perfil' => 'usuario'
        ]);

        User::create([
            'name' => 'teste',
            'email' => 'teste@gmail.com',
            'password' => bcrypt('teste'),
            'perfil' => 'admin'
        ]);
    }
}
