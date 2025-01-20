<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Aluno;

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
