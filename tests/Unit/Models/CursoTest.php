<?php

namespace Tests\Unit\Models;

use App\Models\Aluno;
use App\Models\Curso;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CursoTest extends TestCase
{
    use RefreshDatabase;

    public function test_fillable_attributes(): void
    {
        $curso = Curso::factory()->create([
            'nome' => 'Engenharia de Software',
            'formacao' => 'Graduação',
        ]);

        $this->assertEquals('Engenharia de Software', $curso->nome);
        $this->assertEquals('Graduação', $curso->formacao);
    }

    public function test_alunos_relationship(): void
    {
        $curso = Curso::factory()->has(Aluno::factory()->count(3))->create();

        $this->assertCount(3, $curso->alunos);
        $this->assertInstanceOf(Aluno::class, $curso->alunos->first());
    }

    public function test_authenticatable_trait(): void
    {
        $curso = Curso::factory()->create();

        $this->assertTrue(method_exists($curso, 'getAuthIdentifierName'));
        $this->assertTrue(method_exists($curso, 'getAuthPassword'));
    }

    public function test_notifiable_trait(): void
    {
        $curso = Curso::factory()->create();

        $this->assertTrue(method_exists($curso, 'notify'));
        $this->assertTrue(method_exists($curso, 'routeNotificationFor'));
    }
}