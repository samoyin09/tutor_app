<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            // Not logged in, redirect to login page
            return redirect('/login');
        }

        if (Auth::user()->role !== $role) {
            // Redirect based on their actual role
            if (Auth::user()->role === 'tutor') {
                return redirect('/tutor/dashboard')->with('error', 'Access denied to that page.');
            } elseif (Auth::user()->role === 'student') {
                return redirect('/student/dashboard')->with('error', 'Access denied to that page.');
            } else {
                // fallback redirect
                return redirect('/login')->with('error', 'Access denied.');
            }
        }

        return $next($request);
    }
}