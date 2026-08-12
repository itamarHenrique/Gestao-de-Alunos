<?php

namespace Tests\Feature;

use App\Models\Aluno;
use App\Models\Livro;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LivroFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_pagina_admin_livros(): void
    {
        $admin = User::factory()->create(['perfil' => 'admin']);

        $this->actingAs($admin)
            ->get(route('admin.livros.index'))
            ->assertOk();
    }

    public function test_pagina_admin_criar_livro(): void
    {
        $admin = User::factory()->create(['perfil' => 'admin']);

        $this->actingAs($admin)
            ->get(route('admin.livros.create'))
            ->assertOk();
    }

    public function test_pagina_biblioteca_publica(): void
    {
        $aluno = Aluno::factory()->create();
        Livro::factory()->count(3)->create();

        $this->actingAs($aluno, 'aluno')
            ->get(route('biblioteca.index'))
            ->assertOk();
    }

    public function test_pagina_detalhe_livro(): void
    {
        $aluno = Aluno::factory()->create();
        $livro = Livro::factory()->create();

        $this->actingAs($aluno, 'aluno')
            ->get(route('biblioteca.show', $livro->id))
            ->assertOk();
    }

    public function test_pagina_meus_emprestimos(): void
    {
        $aluno = Aluno::factory()->create();
        $livro = Livro::factory()->create();

        $livro->alunos()->attach($aluno->id, ['data_emprestimo' => now()]);

        $this->actingAs($aluno, 'aluno')
            ->get(route('biblioteca.emprestimos'))
            ->assertOk();
    }

    public function test_criar_livro(): void
    {
        $livro = Livro::factory()->create([
            'titulo' => 'Aprendendo Laravel',
            'quantidade' => 2,
        ]);

        $this->assertDatabaseHas('livros', [
            'titulo' => 'Aprendendo Laravel',
            'quantidade' => 2,
        ]);
    }

    public function test_emprestar_e_devolver_livro(): void
    {
        $aluno = Aluno::factory()->create();
        $livro = Livro::factory()->create(['quantidade' => 1]);

        $this->assertTrue($livro->disponiveis === 1);

        $livro->alunos()->attach($aluno->id, ['data_emprestimo' => now()]);

        $this->assertDatabaseHas('aluno_livro', [
            'aluno_id' => $aluno->id,
            'livro_id' => $livro->id,
        ]);

        $livro->refresh();
        $this->assertTrue($livro->disponiveis === 0);

        $emprestimo = $livro->alunos()
            ->where('aluno_id', $aluno->id)
            ->wherePivotNull('data_devolucao')
            ->first();

        \DB::table('aluno_livro')
            ->where('id', $emprestimo->pivot->id)
            ->update(['data_devolucao' => now()]);

        $livro->refresh();
        $this->assertTrue($livro->disponiveis === 1);
    }

    public function test_nao_emprestar_livro_indisponivel(): void
    {
        $aluno = Aluno::factory()->create();
        $livro = Livro::factory()->create(['quantidade' => 1]);

        $livro->alunos()->attach($aluno->id, ['data_emprestimo' => now()]);
        $livro->refresh();

        $this->assertTrue($livro->disponiveis === 0);
    }
}
