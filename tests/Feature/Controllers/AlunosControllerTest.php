<?php

namespace Tests\Feature\Controllers;

use App\Models\Aluno;
use App\Models\Curso;
use App\Models\Endereco;
use App\Services\AlunoService;
use App\Services\CursoService;
use App\Services\EnderecoService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AlunosControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_view_with_paginated_alunos(): void
    {
        Aluno::factory()->count(15)->create();

        $response = $this->get(route('admin.alunos.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.alunos.index');
        $response->assertViewHas('alunos');
    }

    public function test_get_by_id_returns_resource(): void
    {
        $aluno = Aluno::factory()->has(Endereco::factory())->has(Curso::factory())->create();

        $response = $this->getJson(route('admin.alunos.getById', $aluno->id));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'id', 'user_status', 'primeiro_nome', 'sobrenome', 'nome_completo',
            'endereços', 'curso', 'email', 'celular', 'matricula', 'unidade_de_ensino'
        ]);
    }

    public function test_get_by_id_not_found_returns_404(): void
    {
        $response = $this->getJson(route('admin.alunos.getById', 999));

        $response->assertStatus(404);
    }

    public function test_delete_aluno_redirects_with_success(): void
    {
        $aluno = Aluno::factory()->create();

        $response = $this->delete(route('admin.alunos.delete', $aluno->id));

        $response->assertRedirect(route('admin.alunos.index'));
        $response->assertSessionHas('success', 'Aluno excluído com sucesso.');
        $this->assertDatabaseMissing('alunos', ['id' => $aluno->id]);
    }

    public function test_delete_nonexistent_aluno_redirects_with_error(): void
    {
        $response = $this->delete(route('admin.alunos.delete', 999));

        $response->assertRedirect(route('admin.alunos.index'));
        $response->assertSessionHas('errors');
    }

    public function test_create_returns_view_with_cursos_and_enderecos(): void
    {
        Curso::factory()->count(3)->create();
        Endereco::factory()->count(2)->create();

        $response = $this->get(route('admin.alunos.create'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.alunos.create');
        $response->assertViewHas('cursos');
        $response->assertViewHas('enderecos');
    }

    public function test_edit_returns_view_with_aluno_and_cursos(): void
    {
        $aluno = Aluno::factory()->has(Curso::factory())->create();
        Curso::factory()->count(2)->create();

        $response = $this->get(route('admin.alunos.edit', $aluno->id));

        $response->assertStatus(200);
        $response->assertViewIs('admin.alunos.edit');
        $response->assertViewHas('aluno');
        $response->assertViewHas('cursos');
    }

    public function test_edit_nonexistent_returns_404(): void
    {
        $response = $this->get(route('admin.alunos.edit', 999));

        $response->assertStatus(404);
    }

    public function test_update_aluno_redirects_with_success(): void
    {
        $aluno = Aluno::factory()->has(Endereco::factory())->has(Curso::factory())->create();

        $data = [
            'primeiro_nome' => 'Atualizado',
            'sobrenome' => 'Nome',
            'matricula' => $aluno->matricula,
            'email' => $aluno->email,
            'celular' => $aluno->celular,
            'unidade_de_ensino' => $aluno->unidade_de_ensino,
            'user_status' => 'ativo',
            'enderecos' => [
                'rua' => 'Rua Nova',
                'cep' => '12345-678',
                'numero_da_casa' => '123',
                'bairro' => 'Centro',
            ],
            'curso' => [
                'nome' => 'Novo Curso',
                'formacao' => 'Graduação',
            ],
        ];

        $response = $this->put(route('admin.alunos.update', $aluno->id), $data);

        $response->assertRedirect(route('admin.alunos.index'));
        $response->assertSessionHas('success', 'Aluno atualizado com sucesso.');
        $this->assertDatabaseHas('alunos', ['primeiro_nome' => 'Atualizado']);
    }

    public function test_update_aluno_with_validation_error_redirects_back(): void
    {
        $aluno = Aluno::factory()->create();

        $data = [
            'primeiro_nome' => 'A', // too short
            'sobrenome' => 'Nome',
            'matricula' => $aluno->matricula,
            'email' => $aluno->email,
            'celular' => $aluno->celular,
            'unidade_de_ensino' => $aluno->unidade_de_ensino,
            'user_status' => 'ativo',
            'enderecos' => [],
            'curso' => [],
        ];

        $response = $this->put(route('admin.alunos.update', $aluno->id), $data);

        $response->assertRedirect();
        $response->assertSessionHasErrors('primeiro_nome');
    }
}