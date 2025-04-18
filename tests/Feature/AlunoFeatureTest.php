<?php

namespace Tests\Feature;

use App\Models\Aluno;
use App\Models\Endereco;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AlunoFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_criar_aluno_com_endereco(): void
    {

        $aluno = Aluno::factory()
            ->has(Endereco::factory()->count(1))
            ->create();


        $this->assertDatabaseHas('alunos', [
            'email' => $aluno->email,
        ]);


        $this->assertNotEmpty($aluno->enderecos);


        $this->assertDatabaseHas('aluno_endereco', [
            'aluno_id' => $aluno->id,
            'endereco_id' => $aluno->enderecos->first()->id,
        ]);
    }
}
