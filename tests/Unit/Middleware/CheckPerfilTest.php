<?php

namespace Tests\Unit\Middleware;

use App\Http\Middleware\CheckPerfil;
use App\Models\Aluno;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class CheckPerfilTest extends TestCase
{
    use RefreshDatabase;

    private CheckPerfil $middleware;

    protected function setUp(): void
    {
        parent::setUp();
        $this->middleware = new CheckPerfil();
    }

    public function test_handle_allows_web_user_with_correct_perfil(): void
    {
        $user = User::factory()->create(['perfil' => 'admin']);
        Auth::guard('web')->login($user);

        $request = Request::create('/test', 'GET');
        $next = fn($req) => response('OK', 200);

        $response = $this->middleware->handle($request, $next, 'admin');

        $this->assertEquals(200, $response->status());
    }

    public function test_handle_aborts_403_for_web_user_wrong_perfil(): void
    {
        $user = User::factory()->create(['perfil' => 'usuario']);
        Auth::guard('web')->login($user);

        $request = Request::create('/test', 'GET');
        $next = fn($req) => response('OK', 200);

        try {
            $this->middleware->handle($request, $next, 'admin');
            $this->fail('Expected 403 exception');
        } catch (\Symfony\Component\HttpKernel\Exception\HttpException $e) {
            $this->assertEquals(403, $e->getStatusCode());
        }
    }

    public function test_handle_allows_aluno_guard_for_aluno_perfil(): void
    {
        $aluno = Aluno::factory()->create(['perfil' => 'aluno']);
        Auth::guard('aluno')->login($aluno);

        $request = Request::create('/test', 'GET');
        $next = fn($req) => response('OK', 200);

        $response = $this->middleware->handle($request, $next, 'aluno');

        $this->assertEquals(200, $response->status());
    }

    public function test_handle_aborts_403_for_aluno_guard_wrong_perfil(): void
    {
        $aluno = Aluno::factory()->create(['perfil' => 'aluno']);
        Auth::guard('aluno')->login($aluno);

        $request = Request::create('/test', 'GET');
        $next = fn($req) => response('OK', 200);

        try {
            $this->middleware->handle($request, $next, 'admin');
            $this->fail('Expected 403 exception');
        } catch (\Symfony\Component\HttpKernel\Exception\HttpException $e) {
            $this->assertEquals(403, $e->getStatusCode());
        }
    }

    public function test_handle_redirects_when_no_auth(): void
    {
        $request = Request::create('/test', 'GET');
        $next = fn($req) => response('OK', 200);

        $response = $this->middleware->handle($request, $next, 'admin');

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $response);
        $this->assertEquals(route('login'), $response->getTargetUrl());
    }
}