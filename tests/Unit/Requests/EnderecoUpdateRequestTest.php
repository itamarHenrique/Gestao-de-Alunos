<?php

namespace Tests\Unit\Requests;

use App\Http\Requests\EnderecoUpdateRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EnderecoUpdateRequestTest extends TestCase
{
    use RefreshDatabase;

    private EnderecoUpdateRequest $request;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = new EnderecoUpdateRequest();
    }

    public function test_authorize_returns_true(): void
    {
        $this->assertTrue($this->request->authorize());
    }

    public function test_empty_data_passes(): void
    {
        $data = [];

        $validator = $this->app->make('validator')->make($data, $this->request->rules());

        $this->assertTrue($validator->passes());
    }

    public function test_valid_data_passes(): void
    {
        $data = [
            'rua' => 'Rua Nova',
            'cep' => '12345-678',
            'numero_da_casa' => '123',
            'bairro' => 'Centro',
        ];

        $validator = $this->app->make('validator')->make($data, $this->request->rules());

        $this->assertTrue($validator->passes());
    }

    public function test_rua_max_255(): void
    {
        $data = ['rua' => str_repeat('A', 256)];

        $validator = $this->app->make('validator')->make($data, $this->request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('rua', $validator->errors()->messages());
    }

    public function test_cep_max_20(): void
    {
        $data = ['cep' => str_repeat('1', 21)];

        $validator = $this->app->make('validator')->make($data, $this->request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('cep', $validator->errors()->messages());
    }

    public function test_numero_da_casa_max_10(): void
    {
        $data = ['numero_da_casa' => str_repeat('1', 11)];

        $validator = $this->app->make('validator')->make($data, $this->request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('numero_da_casa', $validator->errors()->messages());
    }

    public function test_bairro_max_255(): void
    {
        $data = ['bairro' => str_repeat('B', 256)];

        $validator = $this->app->make('validator')->make($data, $this->request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('bairro', $validator->errors()->messages());
    }

    public function test_fields_must_be_strings(): void
    {
        $data = [
            'rua' => 123,
            'cep' => 456,
            'numero_da_casa' => 789,
            'bairro' => 999,
        ];

        $validator = $this->app->make('validator')->make($data, $this->request->rules());

        $this->assertTrue($validator->fails());
    }
}