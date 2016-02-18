<?php

namespace Scaffolder;

use Illuminate\Support\ServiceProvider;
use Scaffolder\Commands\ClearCacheCommand;
use Scaffolder\Commands\GeneratorCommand;
use Scaffolder\Commands\InitializeApiCommand;

class ScaffolderServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        // Scaffolder config
        $this->publishes([
            __DIR__ . '/../../config/' => base_path('scaffolder-config/')
        ], 'config');

        // Generator views
        $this->loadViewsFrom(__DIR__ . '/../../views', 'scaffolder');

        // Generator routes
        if (!$this->app->routesAreCached())
        {
            require __DIR__ . '/../../routes/generator.php';
        }
    }

    /**
     * Register the service provider.
     * @return void
     */
    public function register()
    {
        $this->app->singleton('scaffolder.command.generate', function ($app)
        {
            return new GeneratorCommand($app['scaffolder.theme.views'], $app['scaffolder.theme.layouts'], $app['scaffolder.theme.extension'], $app->tagged('scaffolder.extension'));
        });

        $this->app->singleton('scaffolder.command.cache.clear', function ()
        {
            return new ClearCacheCommand();
        });

        $this->app->singleton('scaffolder.command.api.initialize', function ()
        {
            return new InitializeApiCommand();
        });

        $this->commands([
            'scaffolder.command.generate',
            'scaffolder.command.cache.clear',
            'scaffolder.command.api.initialize'
        ]);
    }
}
