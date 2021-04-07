<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HttpHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $text = '')
    {
        $response = $next($request);
        //$response->header('X-JOBS', 'Come work with us.');
        $response->header('X-JOBS', $text);
        return $response;
    }
}
