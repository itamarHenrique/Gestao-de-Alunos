<?php

namespace Tests\Unit\Models;

use App\Models\Aluno;
use App\Models\Endereco;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EnderecoTest extends TestCase
{
    use RefreshDatabase;

    public function test_fillable_attributes(): void
    {
        $endereco = Endereco::factory()->create([
            'rua' => 'Rua das Flores',
            'cep' => '01234-567',
            'numero_da_casa' => '123',
            'bairro' => 'Centro',
        ]);

        $this->assertEquals('Rua das Flores', $endereco->rua);
        $this->assertEquals('01234-567', $endereco->cep);
        $this->assertEquals('123', $endereco->numero_da_casa);
        $this->assertEquals('Centro', $endereco->bairro);
    }

    public function test_alunos_relationship(): void
    {
        $endereco = Endereco::factory()->has(Aluno::factory()->count(2))->create();

        $this->assertCount(2, $endereco->alunos);
        $this->assertInstanceOf(Aluno::class, $endereco->alunos->first());
    }

    public function test_hidden_attributes_not_in_array(): void
    {
        $endereco = Endereco::factory()->create();

        $array = $endereco->toArray();

        $this->assertArrayNotHasKey('pivot', $array);
        $this->assertArrayNotHasKey('alunos', $array);
    }

    public function test_appends_includes_aluno(): void
    {
        $endereco = Endereco::factory()->has(Aluno::factory()->count(1))->create();

        $array = $endereco->toArray();

        $this->assertArrayHasKey('aluno', $array);
    }

    public function test_get_aluno_attribute(): void
    {
        $endereco = Endereco::factory()->has(Aluno::factory()->count(2))->create();

        $alunos = $endereco->aluno;

        $this->assertCount(2, $alunos);
    }

    public function test_authenticatable_trait(): void
    {
        $endereco = Endereco::factory()->create();

        $this->assertTrue(method_exists($endereco, 'getAuthIdentifierName'));
        $this->assertTrue(method_exists($endereco, 'getAuthPassword'));
    }

    public function test_notifiable_trait(): void
    {
        $endereco = Endereco::factory()->create();

        $this->assertTrue(method_exists($endereco, 'notify'));
    }
}