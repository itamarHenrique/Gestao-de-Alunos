<?php

namespace Tests\Unit\Resources;

use App\Http\Resources\AlunoResource;
use App\Models\Aluno;
use App\Models\Curso;
use App\Models\Endereco;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AlunoResourceTest extends TestCase
{
    use RefreshDatabase;

    public function test_to_array_returns_correct_structure(): void
    {
        $aluno = Aluno::factory()->create([
            'primeiro_nome' => 'João',
            'sobrenome' => 'Silva',
            'email' => 'joao@test.com',
            'celular' => '11999999999',
            'matricula' => '2024001',
            'unidade_de_ensino' => 'Campus Central',
            'user_status' => 'ativo',
        ]);

        $resource = new AlunoResource($aluno);
        $array = $resource->toArray($this->createMock(\Illuminate\Http\Request::class));

        $this->assertEquals($aluno->id, $array['id']);
        $this->assertEquals('ativo', $array['user_status']);
        $this->assertEquals('João', $array['primeiro_nome']);
        $this->assertEquals('Silva', $array['sobrenome']);
        $this->assertEquals('João Silva', $array['nome_completo']);
        $this->assertEquals('joao@test.com', $array['email']);
        $this->assertEquals('11999999999', $array['celular']);
        $this->assertEquals('2024001', $array['matricula']);
        $this->assertEquals('Campus Central', $array['unidade_de_ensino']);
    }

    public function test_enderecos_mapping(): void
    {
        $aluno = Aluno::factory()->has(Endereco::factory()->count(2))->create();

        $resource = new AlunoResource($aluno);
        $array = $resource->toArray($this->createMock(\Illuminate\Http\Request::class));

        $this->assertArrayHasKey('endereços', $array);
        $this->assertCount(2, $array['endereços']);

        $endereco = $array['endereços'][0];
        $this->assertArrayHasKey('id', $endereco);
        $this->assertArrayHasKey('nome da rua', $endereco);
        $this->assertArrayHasKey('cep', $endereco);
        $this->assertArrayHasKey('numero da casa', $endereco);
        $this->assertArrayHasKey('bairro', $endereco);
    }

    public function test_cursos_mapping(): void
    {
        $aluno = Aluno::factory()->has(Curso::factory()->count(3))->create();

        $resource = new AlunoResource($aluno);
        $array = $resource->toArray($this->createMock(\Illuminate\Http\Request::class));

        $this->assertArrayHasKey('curso', $array);
        $this->assertCount(3, $array['curso']);

        $curso = $array['curso'][0];
        $this->assertArrayHasKey('id', $curso);
        $this->assertArrayHasKey('nome do curso', $curso);
        $this->assertArrayHasKey('tipo do curso', $curso);
    }

    public function test_empty_relationships_return_empty_arrays(): void
    {
        $aluno = Aluno::factory()->create();

        $resource = new AlunoResource($aluno);
        $array = $resource->toArray($this->createMock(\Illuminate\Http\Request::class));

        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $array['endereços']);
        $this->assertCount(0, $array['endereços']);
        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $array['curso']);
        $this->assertCount(0, $array['curso']);
    }
}