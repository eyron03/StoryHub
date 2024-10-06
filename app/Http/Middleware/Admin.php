<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('admin')->check()) {
            // Access the authenticated user
            $user = Auth::guard('admin')->user();

            // Check if the user type is 'admin'
            if ($user->usertype == 'admin') {
                // User is an admin, allow access
                return $next($request);
            }
        }
        return redirect("/");
    }
}
