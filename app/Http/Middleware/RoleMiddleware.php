<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$allowedRoles)
    {
        $user = $request->user();
    
        // Check if the user is authenticated and has any of the allowed roles
        if (!$user || !$user->hasAnyRole($allowedRoles)) {
            abort(403, 'Unauthorized action.');
        }
    
        return $next($request);
    }
}
