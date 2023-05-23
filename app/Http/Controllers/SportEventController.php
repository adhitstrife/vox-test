<?php

namespace App\Http\Controllers;

use App\Helpers\ApiHelper;
use App\Http\Requests\SportEventRequest;
use Illuminate\Http\Request;

class SportEventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->query('url') !== null) {
            $baseUrl = $request->query('url');    
        } else {
            $baseUrl = env('THIRD_PARTY_URL').'/sport-events';
            if ($request->query('organizerId') !== null) {
                $baseUrl = $baseUrl.'?organizerId='.$request->query('organizerId');
            }
        }

        $response = ApiHelper::makeGetListRequest($baseUrl);
        $decodeResponse = json_decode($response);
        return view('event.index')->with(['datas' => collect($decodeResponse->data), 'paginationLinks' => $decodeResponse->meta->pagination->links]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('event.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SportEventRequest $request)
    {
        $baseUrl = env('THIRD_PARTY_URL').'/sport-events';
        $payload = $request->all();

        $response = ApiHelper::makePostRequest($baseUrl, $payload);
        
        if( $response->status() !== 200 ) {
            $errors = json_decode($response->body(), true)['errors'];
            return redirect()->back()->withErrors($errors);
        } else {
            return redirect()->route('event.index');
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
        $baseUrl = env('THIRD_PARTY_URL').'/sport-events/'.$id;
        $response = ApiHelper::makeGetDetailRequest($baseUrl);

        if( $response->status() !== 200 ) {
            $errors = json_decode($response->body(), true)['errors'];
            return redirect()->back()->withErrors($errors);
        } else {
            return view('event.edit')->with(['data' => json_decode($response)]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SportEventRequest $request, string $id)
    {
        $baseUrl = env('THIRD_PARTY_URL').'/sport-events/'.$id;
        $payload = $request->all();

        $response = ApiHelper::makePutRequest($baseUrl, $payload);
        if( $response->status() !== 204 ) {
            $errors = json_decode($response->body(), true)['errors'];
            return redirect()->back()->withErrors($errors);
        } else {
            return redirect()->route('event.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $baseUrl = env('THIRD_PARTY_URL').'/sport-events/'.$id;
        $response = ApiHelper::makeDeleteRequest($baseUrl);

        if( $response->status() !== 204 ) {
            $errors = json_decode($response->body(), true)['errors'];
            return redirect()->back()->withErrors($errors);
        } else {
            return redirect()->route('event.index');
        }
    }
}
