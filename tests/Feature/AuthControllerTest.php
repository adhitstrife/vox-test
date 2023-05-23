<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    /**
     * Test the index method.
     *
     * @return void
     */
    public function testIndex()
    {
        // Make a GET request to the index method
        $response = $this->get('/login');

        // Assert the response status code
        $response->assertStatus(Response::HTTP_OK);

        // Assert the view name
        $response->assertViewIs('login.index');
    }

    /**
     * Test the store method.
     *
     * @return void
     */
    public function testStore()
    {
        // Mock the API response
        Http::fake([
            '*/users/login' => Http::response(['token' => 'sample_token'], 200),
        ]);

        // Make a POST request to the store method
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        // Assert the response status code
        $response->assertStatus(Response::HTTP_FOUND);

        // Assert the session contains the user data
        $this->assertNotNull(session('user'));
        $this->assertEquals('sample_token', json_decode(Session::get('user'))->token);

        // Assert the redirection to the dashboard index route
        $response->assertRedirect(route('dashboard.index'));
    }
}
