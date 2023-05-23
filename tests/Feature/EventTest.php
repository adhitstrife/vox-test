<?php

namespace Tests\Feature;

use App\Http\Middleware\AuthenticationWithApiToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class EventTest extends TestCase
{
    public function testIndex()
    {
        // Mock the session data
        $userData = [
            'id' => 1975,
            'email' => 'adhitstrife63@gmail.com',
            'token' => 'your_token_here'
        ];
        Session::put('user', json_encode($userData));

        // Mock the API response
        $responseBody = json_encode([
            'data' => [
                [
                    "id" => 0,
                    "eventDate" => "2023-05-23",
                    "eventName" => "string",
                    "eventType" => "string",
                    "organizer" => [
                        "id" => 0,
                        "organizerName" => "string",
                        "imageLocation" => "string"
                    ]
                ]
            ],
            'meta' => [
                'pagination' => [
                    'total' => 450,
                    'count' => 10,
                    'per_page' => 10,
                    'current_page' => 1,
                    'total_pages' => 45,
                    'links' => [
                        'next' => 'https://api.example.com/api/v1/sport-events?page=2'
                    ]
                ]
            ]
        ]);

        Http::fake([
            env('THIRD_PARTY_URL').'/sport-events' => Http::response($responseBody, 200)
        ]);

        // Disable middleware for this test
        $this->withoutMiddleware(AuthenticationWithApiToken::class);

        // Make a GET request to the index method
        $response = $this->get(route('event.index'));
        // Assert that the response status is 200 (OK)
        $response->assertStatus(200);

        // Assert that the view has the expected data
        $response->assertViewHas('datas');
        $response->assertViewHas('paginationLinks');
    }

    public function testStoreWithValidRequest()
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

        // Mock the HTTP request with a successful response
        Http::fake([
            env('THIRD_PARTY_URL').'/sport-events' => Http::response([
                "eventDate" => "2023-05-23",
                "eventType" => "string",
                "eventName" => "string",
                "organizerId" => 0
            ], 200)
        ]);

        // Make a request to the store route
        $response = $this->post(route('event.store'), [
            "eventDate" => "2023-05-23",
            "eventType" => "string",
            "eventName" => "string",
            "organizerId" => 0
        ]);

        // Assert that the response is a redirect
        $response->assertRedirect(route('event.index'));
    }

    public function testStoreWithInValidRequest()
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

        // Mock the HTTP request with a successful response
        Http::fake([
            env('THIRD_PARTY_URL').'/sport-events' => Http::response([
                "eventType" => "string",
                "eventName" => "string",
                "organizerId" => 0
            ], 200)
        ]);

        // Make a request to the store route
        $response = $this->post(route('event.store'), [
            "eventType" => "string",
            "eventName" => "string",
            "organizerId" => 0
        ]);

        // Assert that the response has validation errors for specific fields
        $response->assertSessionHasErrors(['eventDate']);

        // Assert that the response has a specific validation error message
        $response->assertSessionHasErrors([
            'eventDate' => 'The event date field is required.'
        ]);
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
            "id" => 1,
            "eventDate" => "2023-05-23",
            "eventType" => "string",
            "eventName" => "string",
            "organizer" => [
                "id" => 0,
                "organizerName" => "string",
                "imageLocation" => "string"
            ]
        ]);

        Http::fake([
            env('THIRD_PARTY_URL').'/sport-events/1' => Http::response($responseBody, 200)
        ]);

        // Make a request to the edit route
        $response = $this->get(route('event.edit', 1));

        // Assert that the response is successful
        $response->assertSuccessful();

        // Assert that the view is returned with the correct data
        $response->assertViewHas('data', json_decode($responseBody));
    }

    public function testUpdateWithValidRequest()
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
            "id" => 1,
            "eventDate" => "2023-05-23",
            "eventType" => "string",
            "eventName" => "string",
            "organizer" => [
                "id" => 0,
                "organizerName" => "string",
                "imageLocation" => "string"
            ]
        ]);

        // Mock the HTTP request with a successful response
        Http::fake([
            env('THIRD_PARTY_URL').'/sport-events/'.json_decode($responseBody)->id => Http::response([
                "eventDate" => "2023-05-23",
                "eventType" => "update",
                "eventName" => "string",
                "organizerId" => 0
            ], 204)
        ]);

        // Make a request to the store route
        $response = $this->put(route('event.update', json_decode($responseBody)->id), [
            "eventDate" => "2023-05-23",
            "eventType" => "update",
            "eventName" => "string",
            "organizerId" => 0
        ]);
        
        // Assert that the response is a redirect
        $response->assertRedirect(route('event.index'));
    }

    public function testUpdateWithInValidRequest()
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
            "id" => 1,
            "eventDate" => "2023-05-23",
            "eventType" => "string",
            "eventName" => "string",
            "organizer" => [
                "id" => 0,
                "organizerName" => "string",
                "imageLocation" => "string"
            ]
        ]);

        // Mock the HTTP request with a successful response
        Http::fake([
            env('THIRD_PARTY_URL').'/sport-events/'.json_decode($responseBody)->id => Http::response([
                "eventDate" => "2023-05-23",
                "eventName" => "string",
                "organizerId" => 0
            ], 204)
        ]);

        // Make a request to the store route
        $response = $this->put(route('event.update', json_decode($responseBody)->id), [
            "eventDate" => "2023-05-23",
            "eventName" => "string",
            "organizerId" => 0
        ]);

        // Assert that the response has validation errors for specific fields
        $response->assertSessionHasErrors(['eventType']);

        // Assert that the response has a specific validation error message
        $response->assertSessionHasErrors([
            'eventType' => 'The event type field is required.'
        ]);
    }

    public function testDeletRequest()
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
            "id" => 1,
        ]);

        // Mock the HTTP request with a successful response
        Http::fake([
            env('THIRD_PARTY_URL').'/sport-events/'.json_decode($responseBody)->id => Http::response([
                'organizerName' => 'string',
                'imageLocation' => 'string'
            ], 204)
        ]);

        // Make a request to the store route
        $response = $this->delete(route('event.destroy', json_decode($responseBody)->id));
        
        // Assert that the response is a redirect
        $response->assertRedirect(route('event.index'));
    }
}
