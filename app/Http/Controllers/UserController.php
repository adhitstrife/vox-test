<?php

namespace App\Http\Controllers;

use App\Helpers\ApiHelper;
use App\Http\Requests\PasswordRequest;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use App\Http\Middleware\AuthenticationWithApiToken;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('register.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $baseUrl = env('THIRD_PARTY_URL').'/users';
        $response = Http::post($baseUrl, [
            'firstName'=> $request->input('firstname'),
            'lastName'=> $request->input('lastname'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'repeatPassword' => $request->input('password2')
        ]);

        if ($response->status() !== 200) {
            $errors = json_decode($response->body(), true)['errors'];
            return redirect()->back()->withErrors($errors);
        } else {
            return redirect()->route('login.index');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {   
        $baseUrl = env('THIRD_PARTY_URL').'/users/'.$id;
        $response = ApiHelper::makeGetDetailRequest($baseUrl);

        if( $response->status() !== 200 ) {
            $errors = json_decode($response->body(), true)['errors'];
            return redirect()->back()->withErrors($errors);
        } else {
            return view('user.edit')->with(['data' => json_decode($response)]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id)
    {
        $baseUrl = env('THIRD_PARTY_URL').'/users/'.$id;
        $payload = $request->all();

        $response = ApiHelper::makePutRequest($baseUrl, $payload);
        if( $response->status() !== 204 ) {
            $errors = json_decode($response->body(), true)['errors'];
            return redirect()->back()->withErrors($errors);
        } else {
            return redirect()->back()->with(['data' => json_decode($response)]);
        }
    }

    /**
     * Update password the specified resource in storage.
     */
    public function updatePassword(PasswordRequest $request, string $id)
    {
        $baseUrl = env('THIRD_PARTY_URL').'/users/'.$id.'/password';
        $payload = $request->all();

        $response = ApiHelper::makePutRequest($baseUrl, $payload);
        if( $response->status() !== 204 ) {
            $errors = json_decode($response->body(), true)['errors'];
            return redirect()->back()->withErrors($errors);
        } else {
            return redirect()->back();
        }
    }

    /**
     * Remove Session the specified resource from storage.
     */
    public function logout()
    {
        Session::forget('user');
        return redirect()->route('login.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $baseUrl = env('THIRD_PARTY_URL').'/users/'.$id;
        $response = ApiHelper::makeDeleteRequest($baseUrl);

        if( $response->status() !== 204 ) {
            $errors = json_decode($response->body(), true)['errors'];
            return redirect()->back()->withErrors($errors);
        } else {
            return redirect()->route('event.index');
        }
    }
}
