<?php

namespace Tests\Feature;

use App\Http\Middleware\AuthenticationWithApiToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class DashboardTest extends TestCase
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
                    "id" => 212,
                    "organizerName" => "Amir Rudin",
                    "imageLocation" =>"https:\/\/media.licdn.com\/dms\/image\/C4E03AQF9OphsVAaSag\/profile-displayphoto-shrink_200_200\/0\/1516884011177?e=1689206400&v=beta&t=SypHnpsd3aq1qtpVlv7bI_kLPCLncz9PP4a8EQnb2-o"
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
                        'next' => 'https://api.example.com/api/v1/organizers?page=2'
                    ]
                ]
            ]
        ]);
        Http::fake([
            'https://api-sport-events.php6-02.test.voxteneo.com/api/v1/organizers' => Http::response($responseBody, 200)
        ]);

        // Disable middleware for this test
        $this->withoutMiddleware();

        // Make a GET request to the index method
        $response = $this->get(route('dashboard.index'));
        // Assert that the response status is 200 (OK)
        $response->assertStatus(200);

        // Assert that the view has the expected data
        $response->assertViewHas('datas');
        $response->assertViewHas('paginationLinks');

        // Assert any other expectations about the view or response data
    }

    public function testCreateMethod()
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

        // Make a GET request to the create route
        $response = $this->get('/admin/dashboard/create');


        // Assert that the response has a successful status code (e.g., 200)
        $response->assertStatus(200);

        // Assert that the response contains the expected view
        $response->assertViewIs('dashboard.create');
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
            env('THIRD_PARTY_URL').'/organizers' => Http::response([
                'organizerName' => 'string',
                'imageLocation' => 'string'
            ], 200)
        ]);

        // Make a request to the store route
        $response = $this->post(route('dashboard.store'), [
            'organizerName' => 'Example Organizer',
            'imageLocation' => 'example.jpg'
        ]);

        // Assert that the response is a redirect
        $response->assertRedirect(route('dashboard.index'));
    }

    public function testStoreWithInvalidRequest()
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

        // Mock the HTTP request with an error response
        Http::fake([
            'your_api_url_here' => Http::response([
                'errors' => ['Some error message']
            ], 500)
        ]);

        // Make a request to the store route
        $response = $this->post(route('dashboard.store'), [
            'imageLocation' => 'example.jpg'
        ]);

        // Assert that the response has validation errors for specific fields
        $response->assertSessionHasErrors(['organizerName']);

        // Assert that the response has a specific validation error message
        $response->assertSessionHasErrors([
            'organizerName' => 'The organizer name field is required.'
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
            "organizerName" => "string",
            "imageLocation" => "string"
        ]);

        Http::fake([
            env('THIRD_PARTY_URL').'/organizers/1' => Http::response($responseBody, 200)
        ]);

        // Make a request to the edit route
        $response = $this->get(route('dashboard.edit', 1));

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
            "organizerName" => "string",
            "imageLocation" => "string"
        ]);

        // Mock the HTTP request with a successful response
        Http::fake([
            env('THIRD_PARTY_URL').'/organizers/'.json_decode($responseBody)->id => Http::response([
                'organizerName' => 'string',
                'imageLocation' => 'string'
            ], 204)
        ]);

        // Make a request to the store route
        $response = $this->put(route('dashboard.update', json_decode($responseBody)->id), [
            'organizerName' => 'Example Organizer',
            'imageLocation' => 'example.jpg'
        ]);
        
        // Assert that the response is a redirect
        $response->assertRedirect(route('dashboard.index'));
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
            "organizerName" => "string",
            "imageLocation" => "string"
        ]);

        // Mock the HTTP request with a successful response
        Http::fake([
            env('THIRD_PARTY_URL').'/organizers/'.json_decode($responseBody)->id => Http::response([
                'organizerName' => 'string',
                'imageLocation' => 'string'
            ], 204)
        ]);

        // Make a request to the store route
        $response = $this->put(route('dashboard.update', json_decode($responseBody)->id), [
            'organizerName' => 'Example Organizer'
        ]);

        // Assert that the response has validation errors for specific fields
        $response->assertSessionHasErrors(['imageLocation']);

        // Assert that the response has a specific validation error message
        $response->assertSessionHasErrors([
            'imageLocation' => 'The image location field is required.'
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
            env('THIRD_PARTY_URL').'/organizers/'.json_decode($responseBody)->id => Http::response([
                'organizerName' => 'string',
                'imageLocation' => 'string'
            ], 204)
        ]);

        // Make a request to the store route
        $response = $this->delete(route('dashboard.update', json_decode($responseBody)->id));
        
        // Assert that the response is a redirect
        $response->assertRedirect(route('dashboard.index'));
    }
}
