<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles) // Accept multiple roles
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            // Loop through each role and check if the user has at least one of them
            foreach ($roles as $role) {
                if (Auth::user()->hasRole($role)) {
                    return $next($request); // Allow access if any role matches
                }
            }
        }

        // Redirect or show an error message if the user does not have the required role
        return redirect('/unauthorized')->with('error', 'You do not have permission to access this page.');
    }
}
