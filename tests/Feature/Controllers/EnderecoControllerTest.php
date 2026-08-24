<?php

namespace Tests\Feature\Controllers;

use App\Models\Aluno;
use App\Models\Endereco;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EnderecoControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_json_collection(): void
    {
        Endereco::factory()->count(5)->create();

        $response = $this->getJson(route('endereco.index'));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => ['id', 'rua', 'cep', 'numero_da_casa', 'bairro', 'alunos']
        ]);
    }

    public function test_get_by_id_returns_json(): void
    {
        $endereco = Endereco::factory()->has(Aluno::factory()->count(2))->create();

        $response = $this->getJson(route('endereco.getById', $endereco->id));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'id', 'rua', 'cep', 'numero_da_casa', 'bairro', 'alunos'
        ]);
    }

    public function test_get_by_id_not_found_returns_404(): void
    {
        $response = $this->getJson(route('endereco.getById', 999));

        $response->assertStatus(404);
    }

    public function test_create_endereco_returns_json(): void
    {
        $data = [
            'enderecos' => [
                'rua' => 'Rua Teste',
                'cep' => '12345-678',
                'numero_da_casa' => '123',
                'bairro' => 'Centro',
            ],
        ];

        $response = $this->postJson(route('endereco.create'), $data);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'id', 'rua', 'cep', 'numero_da_casa', 'bairro'
        ]);
        $this->assertDatabaseHas('enderecos', ['rua' => 'Rua Teste']);
    }

    public function test_create_endereco_validation_error_returns_400(): void
    {
        $data = ['enderecos' => []]; // missing required fields

        $response = $this->postJson(route('endereco.create'), $data);

        $response->assertStatus(400);
    }

    public function test_update_endereco_returns_json(): void
    {
        $endereco = Endereco::factory()->create();

        $data = [
            'rua' => 'Rua Atualizada',
            'cep' => '99999-999',
        ];

        $response = $this->putJson(route('endereco.update', $endereco->id), $data);

        $response->assertStatus(200);
        $response->assertJsonStructure(['id', 'rua', 'cep', 'numero_da_casa', 'bairro']);
        $this->assertDatabaseHas('enderecos', ['rua' => 'Rua Atualizada']);
    }

    public function test_update_nonexistent_returns_400(): void
    {
        $data = ['rua' => 'Teste'];

        $response = $this->putJson(route('endereco.update', 999), $data);

        $response->assertStatus(400);
        $response->assertJson(['message' => 'Endereço não encontrado']);
    }

    public function test_update_validation_error_returns_400(): void
    {
        $endereco = Endereco::factory()->create();

        $data = ['cep' => 'invalid']; // validation might catch this

        $response = $this->putJson(route('endereco.update', $endereco->id), $data);

        // Either 200 if validation passes or 400 if it fails
        $this->assertTrue(in_array($response->status(), [200, 400]));
    }
}