<?php

namespace Tests\Unit\Requests;

use App\Http\Requests\AlunoPostRequest;
use App\Models\Aluno;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AlunoPostRequestTest extends TestCase
{
    use RefreshDatabase;

    private AlunoPostRequest $request;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = new AlunoPostRequest();
    }

    public function test_authorize_returns_true(): void
    {
        $this->assertTrue($this->request->authorize());
    }

    private function createValidator(array $data): \Illuminate\Validation\Validator
    {
        $this->request->setRouteResolver(function () {
            return new \Illuminate\Routing\Route(['POST'], '/alunos', [], []);
        });

        return $this->app->make('validator')->make($data, $this->request->rules());
    }

    public function test_valid_data_passes_validation(): void
    {
        $data = $this->validData();
        $validator = $this->createValidator($data);

        $this->assertTrue($validator->passes());
    }

    public function test_invalid_primeiro_nome_too_short(): void
    {
        $data = $this->validData(['primeiro_nome' => 'Jo']);
        $validator = $this->createValidator($data);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('primeiro_nome', $validator->errors()->messages());
    }

    public function test_invalid_sobrenome_too_short(): void
    {
        $data = $this->validData(['sobrenome' => 'Si']);
        $validator = $this->createValidator($data);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('sobrenome', $validator->errors()->messages());
    }

    public function test_invalid_matricula_too_short(): void
    {
        $data = $this->validData(['matricula' => '123']);
        $validator = $this->createValidator($data);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('matricula', $validator->errors()->messages());
    }

    public function test_invalid_email_format(): void
    {
        $data = $this->validData(['email' => 'invalid-email']);
        $validator = $this->createValidator($data);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('email', $validator->errors()->messages());
    }

    public function test_invalid_user_status_not_in_config(): void
    {
        $data = $this->validData(['user_status' => 'invalido']);
        $validator = $this->createValidator($data);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('user_status', $validator->errors()->messages());
    }

    public function test_valid_user_status_ativo(): void
    {
        $data = $this->validData(['user_status' => 'ativo']);
        $validator = $this->createValidator($data);

        $this->assertTrue($validator->passes());
    }

    public function test_valid_user_status_inativo(): void
    {
        $data = $this->validData(['user_status' => 'inativo']);
        $validator = $this->createValidator($data);

        $this->assertTrue($validator->passes());
    }

    public function test_invalid_celular_too_short(): void
    {
        $data = $this->validData(['celular' => '12345']);
        $validator = $this->createValidator($data);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('celular', $validator->errors()->messages());
    }

    public function test_invalid_unidade_de_ensino_too_short(): void
    {
        $data = $this->validData(['unidade_de_ensino' => 'ABC']);
        $validator = $this->createValidator($data);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('unidade_de_ensino', $validator->errors()->messages());
    }

    public function test_invalid_enderecos_not_array(): void
    {
        $data = $this->validData(['enderecos' => 'not-an-array']);
        $validator = $this->createValidator($data);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('enderecos', $validator->errors()->messages());
    }

    public function test_invalid_curso_not_array(): void
    {
        $data = $this->validData(['curso' => 'not-an-array']);
        $validator = $this->createValidator($data);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('curso', $validator->errors()->messages());
    }

    public function test_invalid_password_too_short(): void
    {
        $data = $this->validData([
            'password' => '123',
            'password_confirmation' => '123',
        ]);
        $validator = $this->createValidator($data);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('password', $validator->errors()->messages());
    }

    public function test_invalid_password_not_confirmed(): void
    {
        $data = $this->validData([
            'password' => 'password123',
            'password_confirmation' => 'different123',
        ]);
        $validator = $this->createValidator($data);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('password', $validator->errors()->messages());
    }

    public function test_duplicate_matricula_fails_unique(): void
    {
        Aluno::factory()->create(['matricula' => '2024001']);

        $data = $this->validData(['matricula' => '2024001']);
        $validator = $this->createValidator($data);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('matricula', $validator->errors()->messages());
    }

    public function test_duplicate_email_fails_unique(): void
    {
        Aluno::factory()->create(['email' => 'existing@test.com']);

        $data = $this->validData(['email' => 'existing@test.com']);
        $validator = $this->createValidator($data);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('email', $validator->errors()->messages());
    }

    public function test_duplicate_celular_fails_unique(): void
    {
        Aluno::factory()->create(['celular' => '11999999999']);

        $data = $this->validData(['celular' => '11999999999']);
        $validator = $this->createValidator($data);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('celular', $validator->errors()->messages());
    }

    public function test_unique_ignores_current_aluno_id(): void
    {
        $aluno = Aluno::factory()->create([
            'matricula' => '2024001',
            'email' => 'existing@test.com',
            'celular' => '11999999999',
        ]);

        $this->request->setRouteResolver(function () use ($aluno) {
            return new \Illuminate\Routing\Route(['PUT'], "/alunos/{$aluno->id}", [], ['aluno' => $aluno->id]);
        });

        $data = $this->validData([
            'matricula' => '2024001',
            'email' => 'existing@test.com',
            'celular' => '11999999999',
        ]);
        $validator = $this->createValidator($data);

        $this->assertTrue($validator->passes());
    }

    private function validData(array $overrides = []): array
    {
        return array_merge([
            'primeiro_nome' => 'João',
            'sobrenome' => 'Silva',
            'matricula' => '2024' . rand(100, 999),
            'email' => 'joao' . rand(100, 999) . '@test.com',
            'user_status' => 'ativo',
            'celular' => '119' . rand(10000000, 99999999),
            'unidade_de_ensino' => 'Campus Central',
            'enderecos' => [
                'rua' => 'Rua Teste',
                'cep' => '12345-678',
                'numero_da_casa' => '123',
                'bairro' => 'Centro',
            ],
            'curso' => [
                'nome' => 'Engenharia',
            ],
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ], $overrides);
    }
}