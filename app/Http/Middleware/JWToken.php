<?php

namespace App\Http\Middleware;

use Closure;

class JWToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (isset($_COOKIE['token'])) { // All good
            return $next($request);
        } else { // token expired
            session()->flush();
            return redirect('/login')->with('message', 'Your token has expired. Please login.');;
        }

    }
}
