<?php

namespace Tests\Unit\Models;

use App\Models\Aluno;
use App\Models\Curso;
use App\Models\Endereco;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AlunoTest extends TestCase
{
    use RefreshDatabase;

    public function test_nome_completo_accessor(): void
    {
        $aluno = Aluno::factory()->create([
            'primeiro_nome' => 'João',
            'sobrenome' => 'Silva',
        ]);

        $this->assertEquals('João Silva', $aluno->nome_completo);
    }

    public function test_fillable_attributes(): void
    {
        $aluno = Aluno::factory()->create([
            'primeiro_nome' => 'Maria',
            'sobrenome' => 'Santos',
            'matricula' => '2024001',
            'email' => 'maria@test.com',
            'unidade_de_ensino' => 'Campus Central',
            'celular' => '11999999999',
            'user_status' => 'ativo',
            'perfil' => 'aluno',
        ]);

        $this->assertEquals('Maria', $aluno->primeiro_nome);
        $this->assertEquals('Santos', $aluno->sobrenome);
        $this->assertEquals('2024001', $aluno->matricula);
        $this->assertEquals('maria@test.com', $aluno->email);
        $this->assertEquals('Campus Central', $aluno->unidade_de_ensino);
        $this->assertEquals('11999999999', $aluno->celular);
        $this->assertEquals('ativo', $aluno->user_status);
        $this->assertEquals('aluno', $aluno->perfil);
    }

    public function test_hidden_attributes_not_in_array(): void
    {
        $aluno = Aluno::factory()->create(['remember_token' => 'token123']);

        $array = $aluno->toArray();

        $this->assertArrayNotHasKey('remember_token', $array);
        $this->assertArrayNotHasKey('pivot', $array);
    }

    public function test_appends_includes_nome_completo(): void
    {
        $aluno = Aluno::factory()->create();

        $array = $aluno->toArray();

        $this->assertArrayHasKey('nome completo', $array);
    }

    public function test_enderecos_relationship(): void
    {
        $aluno = Aluno::factory()->has(Endereco::factory()->count(2))->create();

        $this->assertCount(2, $aluno->enderecos);
        $this->assertInstanceOf(Endereco::class, $aluno->enderecos->first());
    }

    public function test_cursos_relationship(): void
    {
        $aluno = Aluno::factory()->has(Curso::factory()->count(3))->create();

        $this->assertCount(3, $aluno->cursos);
        $this->assertInstanceOf(Curso::class, $aluno->cursos->first());
    }

    public function test_authenticatable_trait(): void
    {
        $aluno = Aluno::factory()->create();

        $this->assertTrue(method_exists($aluno, 'getAuthIdentifierName'));
        $this->assertTrue(method_exists($aluno, 'getAuthPassword'));
    }
}