<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class AlunosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $cursos = DB::table('cursos')->pluck('id')->toArray();
        $enderecos = DB::table('enderecos')->pluck('id')->toArray();

        for ($i = 0; $i < 10; $i++) {
            DB::table('alunos')->insert([
                'primeiro_nome' => $faker->name,
                'sobrenome' => $faker->lastName(),
                'email' => $faker->unique()->safeEmail,
                'unidade_de_ensino' => $faker->randomElement([
                'Universidade Nova Era',
                'Faculdade Estrela do Saber',
                'Centro Universitário Horizonte',
                'Universidade do Vale do Sol',
                'Faculdade Portal do Conhecimento',
                'Instituto de Ensino Superior Cosmos',
                'Universidade Leste do Brasil',
                'Faculdade Áurea',
                'Centro Universitário Alpha',
                'Faculdade Verde Vale',
                'Universidade Global do Saber',
                'Instituto de Educação Avançada',
                'Faculdade São Lucas',
                'Universidade Nova Geração',
                'Centro de Ensino Prisma',
                'Universidade Luminare',
                'Faculdade Pioneira',
                'Universidade Horizonte Azul',
                'Faculdade Cruzeiro do Sul',
                'Instituto Brasileiro de Ensino Superior (IBES)',
                'Faculdade Integração Global',
            ]),
                'celular' => $faker->phoneNumber,
                'RA' => $faker->randomNumber(7),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
