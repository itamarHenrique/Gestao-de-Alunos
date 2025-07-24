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

          $cursosExatas = [
            'Engenharia de Produção',
            'Engenharia Mecânica',
            'Engenharia Química',
            'Engenharia de Alimentos',
            'Estatística',
            'Química Industrial',
            'Astronomia',
            'Geofísica',
            'Análise de Dados',
            'Tecnologia em Automação Industrial'
        ];

         $cursosHumanas = [
            'Antropologia',
            'Serviço Social',
            'Teologia',
            'Relações Internacionais',
            'Ciências Sociais',
            'Comunicação Social',
            'Gestão de Políticas Públicas',
            'Linguística',
            'Museologia',
            'Arqueologia'
        ];

        $cursosTi = [
            'Ciência da Computação',
            'Engenharia de Software',
            'Análise e Desenvolvimento de Sistemas',
            'Sistemas de Informação',
            'Gestão da Tecnologia da Informação'
        ];

        $novosCursos = array_merge($cursosExatas, $cursosHumanas, $cursosTi);

        foreach ($novosCursos as $curso) {
        
                DB::table('cursos')->insert([
                ['nome' => $curso, 'created_at' => now(), 'updated_at' => now(), 'formacao' => 'Graduação']
            ]);
        }
    }
}
