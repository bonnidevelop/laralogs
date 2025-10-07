<?php

namespace LaraLogs;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class LaraLogsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/laralogs.php', 'laralogs'
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Publish config file
        $this->publishes([
            __DIR__.'/../config/laralogs.php' => config_path('laralogs.php'),
        ], 'laralogs-config');

        // Publish views
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/laralogs'),
        ], 'laralogs-views');

        // Load views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'laralogs');

        // Load routes
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        // Load middleware
        $this->app['router']->aliasMiddleware('laralogs.auth', \LaraLogs\Middleware\LaraLogsAuthMiddleware::class);
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [];
    }
}
