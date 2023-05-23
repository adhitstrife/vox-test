<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrganizersRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use App\Helpers\ApiHelper;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->query('url') !== null) {
            $baseUrl = $request->query('url');    
        } else {
            $baseUrl = env('THIRD_PARTY_URL').'/organizers';
        }
        
        $response = ApiHelper::makeGetListRequest($baseUrl);
        
        $decodeResponse = json_decode($response->body());
        return view('dashboard.index')->with(['datas' => collect($decodeResponse->data), 'paginationLinks' => $decodeResponse->meta->pagination->links]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrganizersRequest $request)
    {
        $baseUrl = env('THIRD_PARTY_URL').'/organizers';
        $payload = $request->all();
        $response = ApiHelper::makePostRequest($baseUrl, $payload);

        if( $response->status() !== 200 ) {
            $errors = json_decode($response->body(), true)['errors'];
            return redirect()->back()->withErrors($errors);
        } else {
            return redirect()->route('dashboard.index');
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
        $baseUrl = env('THIRD_PARTY_URL').'/organizers/'.$id;
        $response = ApiHelper::makeGetDetailRequest($baseUrl);
        
        if( $response->status() !== 200 ) {
            $errors = json_decode($response->body(), true)['errors'];
            return redirect()->back()->withErrors($errors);
        } else {
            return view('dashboard.edit')->with(['data' => json_decode($response)]);
        }
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OrganizersRequest $request, string $id)
    {
        $baseUrl = env('THIRD_PARTY_URL').'/organizers/'.$id;
        $payload = $request->all();

        $response = ApiHelper::makePutRequest($baseUrl, $payload);

        if( $response->status() !== 204 ) {
            $errors = json_decode($response->body(), true)['errors'];
            return redirect()->back()->withErrors($errors);
        } else {
            return redirect()->route('dashboard.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $baseUrl = env('THIRD_PARTY_URL').'/organizers/'.$id;
        $response = ApiHelper::makeDeleteRequest($baseUrl);

        if( $response->status() !== 204 ) {
            $errors = json_decode($response->body(), true)['errors'];
            return redirect()->back()->withErrors($errors);
        } else {
            return redirect()->route('dashboard.index');
        }
    }
}
