<?php

namespace App\Http\Middleware;

use Closure;

class DdvRestfulApi
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
        echo 33;
        var_dump($request);
        return $next($request);
    }
}
