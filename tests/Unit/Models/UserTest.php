<?php

namespace Tests\Unit\Models;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_fillable_attributes(): void
    {
        $user = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => 'password123',
            'perfil' => 'admin',
        ]);

        $this->assertEquals('Admin User', $user->name);
        $this->assertEquals('admin@test.com', $user->email);
        $this->assertEquals('admin', $user->perfil);
    }

    public function test_hidden_attributes_not_in_array(): void
    {
        $user = User::factory()->create([
            'password' => 'secret123',
            'remember_token' => 'token123',
        ]);

        $array = $user->toArray();

        $this->assertArrayNotHasKey('password', $array);
        $this->assertArrayNotHasKey('remember_token', $array);
    }

    public function test_casts_method(): void
    {
        $user = User::factory()->create();

        $reflection = new \ReflectionClass($user);
        $method = $reflection->getMethod('casts');
        $method->setAccessible(true);
        $casts = $method->invoke($user);

        $this->assertArrayHasKey('email_verified_at', $casts);
        $this->assertEquals('datetime', $casts['email_verified_at']);
        $this->assertArrayHasKey('password', $casts);
        $this->assertEquals('hashed', $casts['password']);
    }

    public function test_password_is_hashed(): void
    {
        $user = User::factory()->create([
            'password' => 'plain_password',
        ]);

        $this->assertNotEquals('plain_password', $user->password);
        $this->assertTrue(\Illuminate\Support\Facades\Hash::check('plain_password', $user->password));
    }

    public function test_authenticatable_trait(): void
    {
        $user = User::factory()->create();

        $this->assertTrue(method_exists($user, 'getAuthIdentifierName'));
        $this->assertTrue(method_exists($user, 'getAuthPassword'));
    }

    public function test_notifiable_trait(): void
    {
        $user = User::factory()->create();

        $this->assertTrue(method_exists($user, 'notify'));
    }
}