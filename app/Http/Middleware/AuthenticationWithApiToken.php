<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class AuthenticationWithApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Session::has('user')) {
            // check if token still valid
            $user = json_decode(Session::get('user'));
            $baseUrl = env('THIRD_PARTY_URL').'/users/'.$user->id;
            $response = Http::withHeaders([
                'Authorization' => 'Bearer '.$user->token
            ])->get($baseUrl);
            if ($response->status() !== 200) {
                return redirect()->route('login.index');
            }

            return $next($request);
        }

        return redirect()->route('login.index');
    }
}
