<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiResponse
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Handle unauthenticated responses
        if ($response->status() === 401) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated. Please login first.'
            ], 401);
        }

        return $response;
    }
}