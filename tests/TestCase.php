<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Disable CSRF token validation for tests
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
    }

    protected function actingAsAdmin(): \App\Models\User
    {
        $user = \App\Models\User::factory()->create(['perfil' => 'admin']);
        $this->actingAs($user);
        return $user;
    }

    protected function actingAsAluno(): \App\Models\Aluno
    {
        $aluno = \App\Models\Aluno::factory()->create();
        $this->actingAs($aluno, 'aluno');
        return $aluno;
    }
}