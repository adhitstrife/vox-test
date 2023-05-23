<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use App\Http\Middleware\AuthenticationWithApiToken;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testRegisterMethod()
    {
    
        // Make a request to the edit route
        $response = $this->get(route('users.create'));

        // Assert that the response is successful
        $response->assertSuccessful();
    }

    public function testStoreWithValidRequest()
    {
        // Mock the HTTP request with a successful response
        Http::fake([
            env('THIRD_PARTY_URL').'/users' => Http::response([
                "firstName" => "string",
                "lastName" => "string",
                "email" => "string",
                "password" => "string",
                "repeatPassword" => "string"
            ], 200)
        ]);

        // Make a request to the store route
        $response = $this->post(route('users.store'), [
            "firstName" => "string",
            "lastName" => "string",
            "email" => "string",
            "password" => "string",
            "repeatPassword" => "string"
        ]);

        // Assert that the response is a redirect
        $response->assertRedirect(route('login.index'));
    }

    public function testStoreWithInValidRequest()
    {
        // Mock the HTTP request with a successful response
        Http::fake([
            env('THIRD_PARTY_URL').'/users' => Http::response([
                "lastName" => "string",
                "email" => "string",
                "password" => "string",
                "repeatPassword" => "string"
            ], 200)
        ]);

        // Make a request to the store route
        $response = $this->post(route('users.store'), [
            "lastName" => "string",
            "email" => "string",
            "password" => "string",
            "repeatPassword" => "string"
        ]);

        // Assert that the response has validation errors for specific fields
        $response->assertSessionHasErrors(['firstName']);

        // Assert that the response has a specific validation error message
        $response->assertSessionHasErrors([
            'firstName' => 'The first name field is required.'
        ]);

        // Assert that the response is a redirect
        $response->assertRedirect();

        // Assert that the response redirects back to the previous page
        $response->assertSessionHasErrors();
    }

    public function testEditMethod()
    {
        // Mock the session data
        $userData = [
            'id' => 1975,
            'email' => 'adhitstrife63@gmail.com',
            'token' => 'your_token_here'
        ];
        Session::put('user', json_encode($userData));


        // Disable middleware for this test
        $this->withoutMiddleware(AuthenticationWithApiToken::class);

        // Mock the API response
        $responseBody = json_encode([
            'id' => 1975,
            "firstName" => "string",
            "lastName" => "string",
            'email' => 'adhitstrife63@gmail.com',
        ]);

        Http::fake([
            env('THIRD_PARTY_URL').'/users/'.json_decode($responseBody)->id => Http::response($responseBody, 200)
        ]);

        // Make a request to the edit route
        $response = $this->get(route('profile.edit', json_decode($responseBody)->id));

        // Assert that the response is successful
        $response->assertSuccessful();

        // Assert that the view is returned with the correct data
        $response->assertViewHas('data', json_decode($responseBody));
    }
}
