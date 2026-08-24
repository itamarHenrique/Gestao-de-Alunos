<?php

namespace Tests\Unit\Requests;

use App\Http\Requests\CursoUpdateRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CursoUpdateRequestTest extends TestCase
{
    use RefreshDatabase;

    private CursoUpdateRequest $request;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = new CursoUpdateRequest();
    }

    public function test_authorize_returns_true(): void
    {
        $this->assertTrue($this->request->authorize());
    }

    public function test_valid_data_passes(): void
    {
        $data = ['nome' => 'Novo Nome do Curso'];

        $validator = $this->app->make('validator')->make($data, $this->request->rules());

        $this->assertTrue($validator->passes());
    }

    public function test_invalid_nome_too_short(): void
    {
        $data = ['nome' => 'Ab'];

        $validator = $this->app->make('validator')->make($data, $this->request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('nome', $validator->errors()->messages());
    }

    public function test_invalid_nome_too_long(): void
    {
        $data = ['nome' => str_repeat('A', 101)];

        $validator = $this->app->make('validator')->make($data, $this->request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('nome', $validator->errors()->messages());
    }

    public function test_nome_required(): void
    {
        $data = [];

        $validator = $this->app->make('validator')->make($data, $this->request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('nome', $validator->errors()->messages());
    }
}