<?php

namespace App\Http\Middleware;

use Closure;

class PermissionMiddleware
{
    
    public function handle($request, Closure $next, $permission)
    {

        if($permission !== null && !$request->user()->can($permission)) {
            return redirect('/');
        }

        return $next($request);

    }

}
