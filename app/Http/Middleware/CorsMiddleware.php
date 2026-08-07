<?php

namespace App\Http\Middleware;

use Closure;

class CorsMiddleware
{
    /**
     * Allowed origins for CORS requests.
     */
    private $allowedOrigins = [
        'https://daftar.fhqannashr.org',
    ];

    public function handle($request, Closure $next)
    {
        $origin = $request->header('Origin');

        if ($origin && !in_array($origin, $this->allowedOrigins)) {
            return response()->json(['error' => 'Origin not allowed'], 403);
        }

        // Handle preflight OPTIONS request
        if ($request->isMethod('OPTIONS')) {
            $response = response('', 204);
        } else {
            $response = $next($request);
        }

        if ($origin && in_array($origin, $this->allowedOrigins)) {
            $response->headers->set('Access-Control-Allow-Origin', $origin);
            $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
            $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
        }

        return $response;
    }
}
