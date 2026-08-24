<?php

namespace Tests\Feature\Controllers;

use App\Models\Aluno;
use App\Models\Curso;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CursoControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_view_with_paginated_cursos(): void
    {
        Curso::factory()->count(15)->create();

        $response = $this->get(route('admin.cursos.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.cursos.index');
        $response->assertViewHas('cursos');
    }

    public function test_get_by_id_returns_json(): void
    {
        $curso = Curso::factory()->has(Aluno::factory()->count(2))->create();

        $response = $this->getJson(route('admin.cursos.getById', $curso->id));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'id', 'nome', 'formacao', 'alunos'
        ]);
    }

    public function test_get_by_id_not_found_returns_404(): void
    {
        $response = $this->getJson(route('admin.cursos.getById', 999));

        $response->assertStatus(404);
    }

    public function test_create_returns_view(): void
    {
        $response = $this->get(route('admin.cursos.create'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.cursos.create');
    }

    public function test_store_redirects_with_success(): void
    {
        $data = [
            'nome' => 'Novo Curso',
            'formacao' => 'Graduação',
        ];

        $response = $this->post(route('admin.cursos.store'), $data);

        $response->assertRedirect(route('admin.cursos.index'));
        $response->assertSessionHas('success', 'Curso criado com sucesso.');
        $this->assertDatabaseHas('cursos', ['nome' => 'Novo Curso']);
    }

    public function test_store_duplicate_name_returns_existing(): void
    {
        Curso::factory()->create(['nome' => 'Existente']);

        $data = ['nome' => 'Existente', 'formacao' => 'Graduação'];

        $response = $this->post(route('admin.cursos.store'), $data);

        $response->assertRedirect(route('admin.cursos.index'));
        $response->assertSessionHas('success');
        $this->assertEquals(1, Curso::where('nome', 'Existente')->count());
    }

    public function test_store_validation_error_redirects_back(): void
    {
        $data = ['nome' => 'Ab']; // too short

        $response = $this->post(route('admin.cursos.store'), $data);

        $response->assertRedirect();
        $response->assertSessionHasErrors('nome');
    }

    public function test_update_redirects_with_success(): void
    {
        $curso = Curso::factory()->create(['nome' => 'Antigo']);

        $data = ['nome' => 'Atualizado'];

        $response = $this->put(route('admin.cursos.update', $curso->id), $data);

        $response->assertRedirect(route('admin.cursos.index'));
        $response->assertSessionHas('success', 'Curso atualizado com sucesso.');
        $this->assertDatabaseHas('cursos', ['nome' => 'Atualizado']);
    }

    public function test_update_nonexistent_redirects_with_error(): void
    {
        $data = ['nome' => 'Teste'];

        $response = $this->put(route('admin.cursos.update', 999), $data);

        $response->assertRedirect();
        $response->assertSessionHas('error');
    }

    public function test_update_validation_error_redirects_back(): void
    {
        $curso = Curso::factory()->create();

        $data = ['nome' => 'Ab']; // too short

        $response = $this->put(route('admin.cursos.update', $curso->id), $data);

        $response->assertRedirect();
        $response->assertSessionHasErrors('nome');
    }

    public function test_edit_returns_view_with_curso(): void
    {
        $curso = Curso::factory()->create();

        $response = $this->get(route('admin.cursos.edit', $curso->id));

        $response->assertStatus(200);
        $response->assertViewIs('admin.cursos.edit');
        $response->assertViewHas('curso');
    }

    public function test_edit_nonexistent_redirects_with_error(): void
    {
        $response = $this->get(route('admin.cursos.edit', 999));

        $response->assertRedirect(route('admin.cursos.index'));
        $response->assertSessionHas('error', 'Curso não encontrado.');
    }

    public function test_destroy_redirects_with_success(): void
    {
        $curso = Curso::factory()->create();

        $response = $this->delete(route('admin.cursos.destroy', $curso->id));

        $response->assertRedirect(route('admin.cursos.index'));
        $response->assertSessionHas('success', 'Curso excluído com sucesso.');
        $this->assertDatabaseMissing('cursos', ['id' => $curso->id]);
    }

    public function test_destroy_nonexistent_redirects_with_error(): void
    {
        $response = $this->delete(route('admin.cursos.destroy', 999));

        $response->assertRedirect();
        $response->assertSessionHas('error');
    }
}