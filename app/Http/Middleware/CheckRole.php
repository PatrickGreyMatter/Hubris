<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (! $request->user() || $request->user()->role !== $role) {
            return redirect('/'); // Redirect to home if the user does not have the correct role
        }

        return $next($request);
    }
}
