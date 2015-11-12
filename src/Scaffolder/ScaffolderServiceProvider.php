<?php

namespace Scaffolder;

use Illuminate\Support\ServiceProvider;
use Scaffolder\Commands\ClearCacheCommand;
use Scaffolder\Commands\GeneratorCommand;

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
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('scaffolder.command.generate', function ($app)
        {
            return new GeneratorCommand($app['scaffolder.theme.views'], $app['scaffolder.theme.layouts']);
        });

        $this->app->singleton('scaffolder.command.cache.clear', function ()
        {
            return new ClearCacheCommand();
        });

        $this->commands([
            'scaffolder.command.generate',
            'scaffolder.command.cache.clear'
        ]);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['scaffolder.command.generate', 'scaffolder.command.cache.clear'];
    }
}