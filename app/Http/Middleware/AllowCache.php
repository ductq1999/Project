<?php

namespace App\Http\Middleware;

use Closure;

class AllowCache
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
        $response = $next($request);
        if (!$response->isRedirect()) {
            $response->header('Cache-Control: no-cache, no-store, must-revalidate', true);
        }
        return $response;
    }
}
