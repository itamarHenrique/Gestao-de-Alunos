<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CursoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cursos')->insert([
            ['nome' => 'Ciência da Computação', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Engenharia de Software', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Análise e Desenvolvimento de Sistemas', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Sistemas de Informação', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Gestão da Tecnologia da Informação', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
