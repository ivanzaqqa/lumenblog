<?php

namespace App\Http\Middleware;

use Closure;

class CorsMiddleware
{

    public function handle($request, Closure $next)
    {
        $headers = [
            'Access-Control-Allow-Origin'       => 'http://localhost:3000',
            'Access-Control-Allow-Method'       => 'POST, GET, OPTIONS, PUT, DELETE',
            'Access-Control-Allow-Credential'   => 'true',
            'Access-Control-Max-Age'            => '86400',
            'Access-Control-Allow-Headers'      => 'Content-Type, Authorization, X-Requested-With',
        ];

        if ($request->isMethod('OPTIONS')) {
            return response()->json('{"method":"OPTIONS"}', 200, $headers);
        }

        $response = $next($request);
        foreach ($headers as $key => $value) {
            $response->header($key, $value);
        }

        return $response;
    }
}
