<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlunoRelacionamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $alunoIds = DB::table('alunos')->pluck('id')->toArray();
        $cursoIds = DB::table('cursos')->pluck('id')->toArray();
        $enderecoIds = DB::table('enderecos')->pluck('id')->toArray();
        

        foreach ($alunoIds as $alunoId) {
            // Relaciona de 1 a 2 cursos aleatórios
            $cursos = collect($cursoIds)->random(rand(1, 2));
            foreach ($cursos as $cursoId) {
                DB::table('aluno_curso')->insert([
                    'aluno_id' => $alunoId,
                    'curso_id' => $cursoId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Relaciona 1 endereço
            $enderecoId = collect($enderecoIds)->random();
            DB::table('aluno_endereco')->insert([
                'aluno_id' => $alunoId,
                'endereco_id' => $enderecoId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
