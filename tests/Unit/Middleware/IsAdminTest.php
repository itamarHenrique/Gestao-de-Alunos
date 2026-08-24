<?php

namespace Tests\Unit\Middleware;

use App\Http\Middleware\IsAdmin;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class IsAdminTest extends TestCase
{
    use RefreshDatabase;

    private IsAdmin $middleware;

    protected function setUp(): void
    {
        parent::setUp();
        $this->middleware = new IsAdmin();
    }

    public function test_handle_allows_admin_user(): void
    {
        $user = User::factory()->create(['perfil' => 'admin']);
        Auth::login($user);

        $request = Request::create('/admin', 'GET');
        $next = fn($req) => response('OK', 200);

        $response = $this->middleware->handle($request, $next);

        $this->assertEquals(200, $response->status());
    }

    public function test_handle_aborts_403_for_non_admin(): void
    {
        $user = User::factory()->create(['perfil' => 'usuario']);
        Auth::login($user);

        $request = Request::create('/admin', 'GET');
        $next = fn($req) => response('OK', 200);

        try {
            $this->middleware->handle($request, $next);
            $this->fail('Expected 403 exception');
        } catch (\Symfony\Component\HttpKernel\Exception\HttpException $e) {
            $this->assertEquals(403, $e->getStatusCode());
        }
    }

    public function test_handle_aborts_403_when_not_authenticated(): void
    {
        $request = Request::create('/admin', 'GET');
        $next = fn($req) => response('OK', 200);

        try {
            $this->middleware->handle($request, $next);
            $this->fail('Expected 403 exception');
        } catch (\Symfony\Component\HttpKernel\Exception\HttpException $e) {
            $this->assertEquals(403, $e->getStatusCode());
        }
    }
}