<?php

namespace Tests\Unit\Services;

use App\Models\Aluno;
use App\Models\Curso;
use App\Services\CursoService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CursoServiceTest extends TestCase
{
    use RefreshDatabase;

    private CursoService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new CursoService(new Curso());
    }

    public function test_get_all_returns_paginated_ordered(): void
    {
        Curso::factory()->create(['nome' => 'Curso Z']);
        Curso::factory()->create(['nome' => 'Curso A']);
        Curso::factory()->create(['nome' => 'Curso M']);

        $result = $this->service->getAll();

        $this->assertInstanceOf(\Illuminate\Contracts\Pagination\LengthAwarePaginator::class, $result);
        $this->assertEquals('Curso A', $result->first()->nome);
    }

    public function test_get_all_with_alunos(): void
    {
        Curso::factory()->has(Aluno::factory()->count(2))->create();

        $result = $this->service->getAllWithAlunos();

        $this->assertCount(1, $result);
        $this->assertTrue($result->first()->relationLoaded('alunos'));
        $this->assertCount(2, $result->first()->alunos);
    }

    public function test_get_by_id_returns_curso_with_alunos(): void
    {
        $curso = Curso::factory()->has(Aluno::factory()->count(3))->create();

        $result = $this->service->getById($curso->id);

        $this->assertNotNull($result);
        $this->assertEquals($curso->id, $result->id);
        $this->assertTrue($result->relationLoaded('alunos'));
        $this->assertCount(3, $result->alunos);
    }

    public function test_get_by_id_returns_null_for_nonexistent(): void
    {
        $result = $this->service->getById(999);

        $this->assertNull($result);
    }

    public function test_create_curso_returns_existing_if_same_name(): void
    {
        $existing = Curso::factory()->create(['nome' => 'Engenharia']);

        $data = ['nome' => 'Engenharia', 'formacao' => 'Graduação'];
        $result = $this->service->createCurso($data);

        $this->assertEquals($existing->id, $result->id);
        $this->assertEquals('Engenharia', $result->nome);
    }

    public function test_create_curso_creates_new(): void
    {
        $data = ['nome' => 'Novo Curso', 'formacao' => 'Graduação'];
        $result = $this->service->createCurso($data);

        $this->assertInstanceOf(Curso::class, $result);
        $this->assertEquals('Novo Curso', $result->nome);
        $this->assertEquals('Graduação', $result->formacao);
        $this->assertDatabaseHas('cursos', ['nome' => 'Novo Curso']);
    }

    public function test_update_curso(): void
    {
        $curso = Curso::factory()->create(['nome' => 'Antigo', 'formacao' => 'Graduação']);

        $data = ['nome' => 'Atualizado', 'formacao' => 'Pós-graduação'];
        $result = $this->service->updateCurso($curso->id, $data);

        $this->assertNotNull($result);
        $this->assertEquals('Atualizado', $result->nome);
        $this->assertEquals('Pós-graduação', $result->formacao);
    }

    public function test_update_curso_handles_nested_curso_key(): void
    {
        $curso = Curso::factory()->create(['nome' => 'Original']);

        $data = ['curso' => ['nome' => 'Via Nested']];
        $result = $this->service->updateCurso($curso->id, $data);

        $this->assertNotNull($result);
        $this->assertEquals('Via Nested', $result->nome);
    }

    public function test_update_nonexistent_curso_throws_exception(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Curso não encontrado');

        $this->service->updateCurso(999, ['nome' => 'Teste']);
    }

    public function test_delete_by_id(): void
    {
        $curso = Curso::factory()->create();

        $deleted = $this->service->deleteById($curso->id);

        $this->assertEquals(1, $deleted);
        $this->assertDatabaseMissing('cursos', ['id' => $curso->id]);
    }

    public function test_delete_nonexistent_returns_zero(): void
    {
        $deleted = $this->service->deleteById(999);

        $this->assertEquals(0, $deleted);
    }
}