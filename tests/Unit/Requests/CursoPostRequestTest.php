<?php

namespace Tests\Unit\Requests;

use App\Http\Requests\CursoPostRequest;
use App\Models\Curso;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CursoPostRequestTest extends TestCase
{
    use RefreshDatabase;

    private CursoPostRequest $request;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = new CursoPostRequest();
    }

    public function test_authorize_returns_true(): void
    {
        $this->assertTrue($this->request->authorize());
    }

    public function test_valid_data_passes(): void
    {
        $data = [
            'nome' => 'Engenharia de Software',
            'formacao' => 'Graduação',
        ];

        $validator = $this->app->make('validator')->make($data, $this->request->rules());

        $this->assertTrue($validator->passes());
    }

    public function test_formacao_optional(): void
    {
        $data = ['nome' => 'Curso Sem Formação'];

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

    public function test_duplicate_nome_fails_unique(): void
    {
        Curso::factory()->create(['nome' => 'Engenharia']);

        $data = ['nome' => 'Engenharia'];

        $validator = $this->app->make('validator')->make($data, $this->request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('nome', $validator->errors()->messages());
    }

    public function test_valid_formacao_from_config(): void
    {
        $data = [
            'nome' => 'Curso Teste',
            'formacao' => 'Graduação',
        ];

        $validator = $this->app->make('validator')->make($data, $this->request->rules());

        $this->assertTrue($validator->passes());
    }

    public function test_invalid_formacao_not_in_config(): void
    {
        $data = [
            'nome' => 'Curso Teste',
            'formacao' => 'Invalido',
        ];

        $validator = $this->app->make('validator')->make($data, $this->request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('formacao', $validator->errors()->messages());
    }
}