<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Session\SessionManager;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Testing\TestResponse;
use Mockery;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class MiddlewareTest extends TestCase
{
    public function testValidToken()
    {
        $id = 1975;
        // Mock the Session facade
        $this->mockSession([
            'has' => true,
            'get' => json_encode([
                'id' => $id,
                'email' => 'adhitstrife63@gmail.com',
                'token' => 'your_valid_token_here'
            ])
        ]);

        // Mock the Http facade
        Http::fake([
            'https://api-sport-events.php6-02.test.voxteneo.com/api/v1/users/'.$id => Http::response(['status' => 'success'], 200)
        ]);

        // Create an instance of the middleware
        $middleware = new \App\Http\Middleware\AuthenticationWithApiToken();

        // Create a mock request and closure
        $request = Request::create('/');
        $closure = function ($request) {
            return new Response('next');
        };

        // Call the middleware's handle() method
        $response = $middleware->handle($request, $closure);

        // Assert that the response is the expected "next" value
        $this->assertEquals('next', $response->getContent());
    }

    public function testInvalidToken()
    {
        // Make a request to the protected route
        $response = $this->get('/admin/dashboard');
        // Assert that the response is a redirect
        $response->assertRedirect('/login');
    }

    private function mockSession($methods)
    {
        $session = $this->partialMock(\Illuminate\Session\SessionManager::class, function ($mock) use ($methods) {
            $mock->shouldReceive('has')->andReturnUsing(function ($key) use ($methods) {
                return $methods['has'];
            });
            $mock->shouldReceive('get')->andReturnUsing(function ($key) use ($methods) {
                return $methods['get'];
            });
        });

        $this->app->instance('session', $session);
        Session::swap($session);
    }
}
