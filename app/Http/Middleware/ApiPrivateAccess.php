<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiPrivateAccess
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->bearerToken() !== '12345678') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return $next($request);
    }
    protected function unauthenticated($request, \Illuminate\Auth\AuthenticationException $exception)
    {
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest(route('logwadin'));
    }
}
