<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated as an admin
        if (!Auth::guard('admin')->check()) {
            // Redirect to admin login page if not authenticated
            return redirect()->route('admin.login');
        }

        // Continue with the request if authenticated
        return $next($request);
    }
}
