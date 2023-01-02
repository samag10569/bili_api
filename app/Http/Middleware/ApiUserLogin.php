<?php

namespace App\Http\Middleware;

use Closure;

class ApiUserLogin
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
        if (!auth('api')->user()) {
            return response()->json(['success' => false,'message' => 'NotLogin']);
        }
        return $next($request);
    }
}
