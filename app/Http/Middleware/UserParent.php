<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class UserParent
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('parent')->check()) {
            // Access the authenticated user
            $user = Auth::guard('parent')->user();

            // Check if the user type is 'parent'
            if ($user->usertype == 'parent') {
                // User is an parent, allow access
                return $next($request);
            }
        }
          return redirect("/");
    }

}
