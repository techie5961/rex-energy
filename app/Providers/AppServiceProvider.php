<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // load helpers
        require_once app_path('Helpers/general.php');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 

    }
}
