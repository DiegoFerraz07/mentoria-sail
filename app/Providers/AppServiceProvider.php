<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $models = array(
            'Supply',
            'Types'
        );

        foreach ($models as $model) {
            $this->app->bind("App\Interfaces\\{$model}RepositoryInterface", "App\Repositories\\{$model}Repository");
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::directive('date_ptbr', function (string $expression) {
            return "<?php echo DateTime::createFromFormat('Y-m-d', $expression)->format('d/m/Y') ?>";
        });
        Blade::directive('datetime_ptbr', function (string $expression) {
            return "<?php echo DateTime::createFromFormat('Y-m-d H:i:s', $expression)->format('d/m/Y H:i:s') ?>";
        });
    }
}
