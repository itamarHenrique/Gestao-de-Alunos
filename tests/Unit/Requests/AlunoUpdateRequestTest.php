<?php

namespace Tests\Unit\Requests;

use App\Http\Requests\AlunoUpdateRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AlunoUpdateRequestTest extends TestCase
{
    use RefreshDatabase;

    private AlunoUpdateRequest $request;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = new AlunoUpdateRequest();
    }

    public function test_authorize_returns_true(): void
    {
        $this->assertTrue($this->request->authorize());
    }

    public function test_valid_optional_data_passes(): void
    {
        $data = [
            'primeiro_nome' => 'João',
            'sobrenome' => 'Silva',
            'matricula' => '2024001',
            'email' => 'joao@test.com',
            'celular' => '11999999999',
            'unidade_de_ensino' => 'Campus Central',
            'enderecos' => [],
            'curso' => [],
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $validator = $this->app->make('validator')->make($data, $this->request->rules());

        $this->assertTrue($validator->passes());
    }

    public function test_empty_data_passes(): void
    {
        $data = [];

        $validator = $this->app->make('validator')->make($data, $this->request->rules());

        $this->assertTrue($validator->passes());
    }

    public function test_invalid_primeiro_nome_too_short(): void
    {
        $data = ['primeiro_nome' => 'Jo'];

        $validator = $this->app->make('validator')->make($data, $this->request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('primeiro_nome', $validator->errors()->messages());
    }

    public function test_invalid_email_format(): void
    {
        $data = ['email' => 'invalid'];

        $validator = $this->app->make('validator')->make($data, $this->request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('email', $validator->errors()->messages());
    }

    public function test_password_nullable(): void
    {
        $data = ['password' => null];

        $validator = $this->app->make('validator')->make($data, $this->request->rules());

        $this->assertTrue($validator->passes());
    }

    public function test_password_min_8_chars(): void
    {
        $data = [
            'password' => '123',
            'password_confirmation' => '123',
        ];

        $validator = $this->app->make('validator')->make($data, $this->request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('password', $validator->errors()->messages());
    }

    public function test_password_confirmed(): void
    {
        $data = [
            'password' => 'password123',
            'password_confirmation' => 'different',
        ];

        $validator = $this->app->make('validator')->make($data, $this->request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('password', $validator->errors()->messages());
    }

    public function test_sometimes_fields_are_optional(): void
    {
        $fields = [
            'primeiro_nome', 'sobrenome', 'matricula', 'celular',
            'unidade_de_ensino', 'enderecos', 'curso'
        ];

        foreach ($fields as $field) {
            $data = [$field => 'valid value'];
            $validator = $this->app->make('validator')->make($data, $this->request->rules());
            $this->assertTrue($validator->passes(), "Field {$field} should be optional");
        }
    }
}