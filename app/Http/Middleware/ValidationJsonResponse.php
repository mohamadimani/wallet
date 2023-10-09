<?php

namespace App\Http\Middleware;

use Closure;

class ValidationJsonResponse {

    public function handle($request, Closure $next)
    {
        $request->headers->set('Accept', 'application/json');
        return $next($request)
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
        ->header('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, X-Token-Auth, Authorization');
    }

}