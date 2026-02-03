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
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::directive('continueIfNotArray', function ($expression) {
            return "<?php if (!is_array($expression) && !($expression instanceof \\ArrayAccess)) continue; ?>";
        });

        Blade::directive('normalizeArray', function ($expression) {
            return "<?php if (!is_array($expression) && !($expression instanceof \\ArrayAccess)) { $expression = []; } ?>";
        });
    }
}
