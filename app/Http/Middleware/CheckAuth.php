<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class CheckAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Session::has('user') && !Session::has('api_token')) {
            // Check if it's an API request or expects JSON
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated'], 401);
            }

            // Store intended URL
            Session::put('url.intended', $request->fullUrl());

            // Redirect to login page
            return redirect('/login')->with('error', 'Please login to continue.');
        }

        return $next($request);
    }
}
