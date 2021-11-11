<?php

namespace App\Http\Middleware;

use Closure;

class TinyParcelMiddleware
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
        if (!$request->bearerToken() || $request->bearerToken() != config('tinyparcel.tp_secret')) {
            return response()->json([
                'success' => false,
                'error' => 'Unauthorized',
            ], 401);
        }

        return $next($request);
    }
}
