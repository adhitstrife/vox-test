<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class ApiHelper {
    public static function makeGetListRequest($baseUrl) {
        $user = json_decode(Session::get('user'));
        $token = $user->token;
    
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$token
        ])->get($baseUrl);

        return $response;
    }

    public static function makePostRequest($baseUrl, $payload) {
        $user = json_decode(Session::get('user'));
        $token = $user->token;
    
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$token
        ])->post($baseUrl, $payload);

        return $response;
    }

    public static function makePostRequestWithoutToken($baseUrl, $payload) {
        $response = Http::post($baseUrl, $payload);

        return $response;
    }

    public static function makeGetDetailRequest($baseUrl) {
        $user = json_decode(Session::get('user'));
        $token = $user->token;
    
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$token
        ])->get($baseUrl);
        
        return $response;
    }

    public static function makePutRequest($baseUrl, $payload) {
        $user = json_decode(Session::get('user'));
        $token = $user->token;
    
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$token
        ])->put($baseUrl, $payload);

        return $response;
    }

    public static function makeDeleteRequest($baseUrl) {
        $user = json_decode(Session::get('user'));
        $token = $user->token;
    
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$token
        ])->delete($baseUrl);
        
        return $response;
    }


}
