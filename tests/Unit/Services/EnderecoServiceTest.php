<?php

namespace Tests\Unit\Services;

use App\Models\Aluno;
use App\Models\Endereco;
use App\Services\EnderecoService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EnderecoServiceTest extends TestCase
{
    use RefreshDatabase;

    private EnderecoService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new EnderecoService(new Endereco());
    }

    public function test_get_all_returns_collection_with_alunos(): void
    {
        Endereco::factory()->has(Aluno::factory()->count(2))->create();

        $result = $this->service->getAll();

        $this->assertCount(1, $result);
        $this->assertTrue($result->first()->relationLoaded('alunos'));
    }

    public function test_get_by_id_returns_endereco_with_alunos(): void
    {
        $endereco = Endereco::factory()->has(Aluno::factory()->count(3))->create();

        $result = $this->service->getById($endereco->id);

        $this->assertNotNull($result);
        $this->assertEquals($endereco->id, $result->id);
        $this->assertTrue($result->relationLoaded('alunos'));
        $this->assertCount(3, $result->alunos);
    }

    public function test_get_by_id_returns_null_for_nonexistent(): void
    {
        $result = $this->service->getById(999);

        $this->assertNull($result);
    }

    public function test_create_endereco(): void
    {
        $data = [
            'rua' => 'Rua Nova',
            'cep' => '12345-678',
            'numero_da_casa' => '456',
            'bairro' => 'Bairro Novo',
        ];

        $endereco = $this->service->createEndereco($data);

        $this->assertInstanceOf(Endereco::class, $endereco);
        $this->assertEquals('Rua Nova', $endereco->rua);
        $this->assertEquals('12345-678', $endereco->cep);
        $this->assertEquals('456', $endereco->numero_da_casa);
        $this->assertEquals('Bairro Novo', $endereco->bairro);
        $this->assertDatabaseHas('enderecos', ['rua' => 'Rua Nova']);
    }

    public function test_delete(): void
    {
        $endereco = Endereco::factory()->create();

        $deleted = $this->service->delete($endereco->id);

        $this->assertEquals(1, $deleted);
        $this->assertDatabaseMissing('enderecos', ['id' => $endereco->id]);
    }

    public function test_delete_nonexistent_returns_zero(): void
    {
        $deleted = $this->service->delete(999);

        $this->assertEquals(0, $deleted);
    }

    public function test_update_endereco(): void
    {
        $endereco = Endereco::factory()->create([
            'rua' => 'Rua Antiga',
            'cep' => '11111-111',
        ]);

        $data = [
            'rua' => 'Rua Nova',
            'cep' => '99999-999',
        ];

        $updated = $this->service->updateEndereco($data, $endereco->id);

        $this->assertNotNull($updated);
        $this->assertEquals('Rua Nova', $updated->rua);
        $this->assertEquals('99999-999', $updated->cep);
    }

    public function test_update_endereco_handles_nested_enderecos_key(): void
    {
        $endereco = Endereco::factory()->create(['rua' => 'Original']);

        $data = ['enderecos' => ['rua' => 'Via Nested']];
        $updated = $this->service->updateEndereco($data, $endereco->id);

        $this->assertNotNull($updated);
        $this->assertEquals('Via Nested', $updated->rua);
    }

    public function test_update_nonexistent_throws_exception(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Endereço não encontrado');

        $this->service->updateEndereco(['rua' => 'Teste'], 999);
    }
}