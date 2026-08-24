<?php

namespace Tests\Unit\Requests;

use App\Http\Requests\EnderecoPostRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EnderecoPostRequestTest extends TestCase
{
    use RefreshDatabase;

    private EnderecoPostRequest $request;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = new EnderecoPostRequest();
    }

    public function test_authorize_returns_true(): void
    {
        $this->assertTrue($this->request->authorize());
    }

    public function test_valid_enderecos_array_passes(): void
    {
        $data = [
            'enderecos' => [
                'rua' => 'Rua Teste',
                'cep' => '12345-678',
                'numero_da_casa' => '123',
                'bairro' => 'Centro',
            ],
        ];

        $validator = $this->app->make('validator')->make($data, $this->request->rules());

        $this->assertTrue($validator->passes());
    }

    public function test_enderecos_required(): void
    {
        $data = [];

        $validator = $this->app->make('validator')->make($data, $this->request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('enderecos', $validator->errors()->messages());
    }

    public function test_enderecos_must_be_array(): void
    {
        $data = ['enderecos' => 'not-array'];

        $validator = $this->app->make('validator')->make($data, $this->request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('enderecos', $validator->errors()->messages());
    }

    public function test_optional_fields_are_strings(): void
    {
        $data = [
            'enderecos' => [
                'rua' => 123, // not string
                'cep' => 456,
                'numero_da_casa' => 789,
                'bairro' => 999,
            ],
        ];

        $validator = $this->app->make('validator')->make($data, $this->request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('enderecos.rua', $validator->errors()->messages());
    }

    public function test_optional_fields_when_strings_pass(): void
    {
        $data = [
            'enderecos' => [
                'rua' => 'Rua Teste',
                'cep' => '12345-678',
                'numero_da_casa' => '123',
                'bairro' => 'Centro',
            ],
        ];

        $validator = $this->app->make('validator')->make($data, $this->request->rules());

        $this->assertTrue($validator->passes());
    }
}