<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$role): Response
    {
        // Check if the user is authenticated as an admin
        if (Auth::check() && Auth::user()->hasAnyRole($role)) {
            return $next($request);
        }
        Auth::logout();

        return back()->withErrors([
            'email' => 'You do not have access to this page.',
        ]);
    }
}
