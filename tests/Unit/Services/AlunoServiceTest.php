<?php

namespace Tests\Unit\Services;

use App\Models\Aluno;
use App\Models\Curso;
use App\Models\Endereco;
use App\Services\AlunoService;
use App\Services\EnderecoService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AlunoServiceTest extends TestCase
{
    use RefreshDatabase;

    private AlunoService $service;
    private EnderecoService $enderecoService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->enderecoService = $this->app->make(EnderecoService::class);
        $this->service = new AlunoService(new Aluno(), $this->enderecoService);
    }

    public function test_get_all_returns_paginated_collection(): void
    {
        Aluno::factory()->count(15)->create();

        $result = $this->service->getAll();

        $this->assertInstanceOf(\Illuminate\Contracts\Pagination\LengthAwarePaginator::class, $result);
        $this->assertCount(10, $result->items());
    }

    public function test_get_all_includes_relationships(): void
    {
        Aluno::factory()->has(Endereco::factory())->has(Curso::factory())->create();

        $result = $this->service->getAll();

        $aluno = $result->first();
        $this->assertTrue($aluno->relationLoaded('enderecos'));
        $this->assertTrue($aluno->relationLoaded('cursos'));
    }

    public function test_get_by_id_returns_aluno_with_enderecos(): void
    {
        $aluno = Aluno::factory()->has(Endereco::factory()->count(2))->create();

        $result = $this->service->getById($aluno->id);

        $this->assertNotNull($result);
        $this->assertEquals($aluno->id, $result->id);
        $this->assertTrue($result->relationLoaded('enderecos'));
    }

    public function test_get_by_id_returns_null_for_nonexistent(): void
    {
        $result = $this->service->getById(999);

        $this->assertNull($result);
    }

    public function test_create_aluno(): void
    {
        $data = [
            'primeiro_nome' => 'João',
            'sobrenome' => 'Silva',
            'matricula' => '2024001',
            'email' => 'joao@test.com',
            'user_status' => 'ativo',
            'celular' => '11999999999',
            'unidade_de_ensino' => 'Campus Central',
            'password' => 'password123',
            'endereco' => null,
            'curso' => null,
        ];

        $aluno = $this->service->createAluno($data);

        $this->assertInstanceOf(Aluno::class, $aluno);
        $this->assertEquals('João', $aluno->primeiro_nome);
        $this->assertEquals('Silva', $aluno->sobrenome);
        $this->assertEquals('2024001', $aluno->matricula);
        $this->assertEquals('joao@test.com', $aluno->email);
        $this->assertTrue(\Illuminate\Support\Facades\Hash::check('password123', $aluno->password));
        $this->assertDatabaseHas('alunos', ['email' => 'joao@test.com']);
    }

    public function test_create_aluno_with_endereco_and_curso(): void
    {
        $data = [
            'primeiro_nome' => 'Maria',
            'sobrenome' => 'Santos',
            'matricula' => '2024002',
            'email' => 'maria@test.com',
            'user_status' => 'ativo',
            'celular' => '11888888888',
            'unidade_de_ensino' => 'Campus Norte',
            'password' => 'password123',
            'endereco' => null,
            'curso' => null,
        ];

        $aluno = $this->service->createAluno($data);

        $this->assertDatabaseHas('alunos', ['matricula' => '2024002']);
    }

    public function test_delete_aluno(): void
    {
        $aluno = Aluno::factory()->create();

        $deleted = $this->service->deleteAluno($aluno->id);

        $this->assertEquals(1, $deleted);
        $this->assertDatabaseMissing('alunos', ['id' => $aluno->id]);
    }

    public function test_delete_nonexistent_aluno_returns_zero(): void
    {
        $deleted = $this->service->deleteAluno(999);

        $this->assertEquals(0, $deleted);
    }

    public function test_update_aluno(): void
    {
        $aluno = Aluno::factory()->create([
            'primeiro_nome' => 'Antigo',
            'sobrenome' => 'Nome',
            'email' => 'antigo@test.com',
        ]);

        $data = [
            'primeiro_nome' => 'Novo',
            'sobrenome' => 'Nome Atualizado',
            'email' => 'novo@test.com',
            'enderecos' => [],
            'curso' => [],
        ];

        $updated = $this->service->updateAluno($data, $aluno->id);

        $this->assertNotNull($updated);
        $this->assertEquals('Novo', $updated->primeiro_nome);
        $this->assertEquals('Nome Atualizado', $updated->sobrenome);
        $this->assertEquals('novo@test.com', $updated->email);
    }

    public function test_update_aluno_removes_enderecos_and_curso_from_data(): void
    {
        $aluno = Aluno::factory()->create();

        $data = [
            'primeiro_nome' => 'Teste',
            'enderecos' => ['rua' => 'Rua Teste'],
            'curso' => ['nome' => 'Curso Teste'],
        ];

        $updated = $this->service->updateAluno($data, $aluno->id);

        $this->assertNotNull($updated);
        $this->assertEquals('Teste', $updated->primeiro_nome);
    }

    public function test_update_nonexistent_aluno_returns_null(): void
    {
        $data = ['primeiro_nome' => 'Teste'];

        $result = $this->service->updateAluno($data, 999);

        $this->assertNull($result);
    }
}