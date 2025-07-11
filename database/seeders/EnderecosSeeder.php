<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class EnderecosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Inserir endereços fictícios na tabela 'enderecos'
        for ($i = 0; $i < 10; $i++) {
            DB::table('enderecos')->insert([
                'rua' => $faker->streetAddress,
                'bairro' => $faker->word,
                'cep' => $faker->postcode,
                'numero_da_casa' => $faker->numberBetween(20, 300),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
