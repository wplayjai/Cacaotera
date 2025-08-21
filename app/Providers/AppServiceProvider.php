<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Forzar HTTPS en producción y cuando se use ngrok
        $appUrl = env('APP_URL');
        if (env('APP_ENV') === 'production' || (Str::contains($appUrl, 'ngrok'))) {
            \URL::forceScheme('https');
        }
    }
}
