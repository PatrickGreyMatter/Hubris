<?php

namespace App\Http;

use Illuminate\Foundation\Configuration\Middleware;

class AppMiddleware
{
    public function __invoke(Middleware $middleware)
    {
        // Register your middleware aliases
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'contributor' => \App\Http\Middleware\ContributorMiddleware::class,
            'user' => \App\Http\Middleware\UserMiddleware::class,
        ]);

        // Register global middleware
        $middleware->append([
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        ]);

        // Register middleware groups
        $middleware->appendToGroup('web', [
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);

        $middleware->appendToGroup('api', [
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);
    }
}
