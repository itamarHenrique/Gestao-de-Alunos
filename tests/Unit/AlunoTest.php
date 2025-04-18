<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Aluno;
use Tests\TestCase; // <- Use a TestCase do Laravel


class AlunoTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_nome_completo(): void
    {
        $aluno = Aluno::factory()->create();

        $nomeCompleto = $aluno->primeiro_nome . ' ' . $aluno->sobrenome;

        $this->assertEquals($nomeCompleto, $aluno->nome_completo);
    }
}
