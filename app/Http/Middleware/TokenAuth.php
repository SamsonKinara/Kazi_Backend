<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class TokenAuth
{
    /**
     * Handle an incoming request with token-based authentication.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $authHeader = $request->header('Authorization');

        if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
            return response()->json(['message' => 'Authorization token not provided'], 401);
        }

        $token = substr($authHeader, 7); // Remove "Bearer " prefix

        $user = User::where('token', $token)->first();

        if (! $user) {
            return response()->json(['message' => 'Invalid or expired token'], 401);
        }

        // Set the authenticated user on the request
        $request->setUserResolver(fn () => $user);

        return $next($request);
    }
}

