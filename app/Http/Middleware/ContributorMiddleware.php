<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContributorMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role == 'contributor') {
            return $next($request);
        }

        return redirect('/')->with('error', 'Access denied. Contributors only.');
    }
}
