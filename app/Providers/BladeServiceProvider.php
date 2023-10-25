<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        
        Blade::directive('active', function ($route) {
            return "<?php echo str_contains({$route}, explode('.', Route::currentRouteName())[0]) ? ' active ' : ''; ?>"; 
        });

        Blade::directive('showMenu', function ($routes) {
            return "<?php echo in_array(explode('.', Route::currentRouteName())[0], {$routes}) ? ' show ' : ''; ?>"; 
        });
    }
}
