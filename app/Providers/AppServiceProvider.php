<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ini_set('max_execution_time', env('APP_REQUEST_TIMEOUT', 3000));

        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}
