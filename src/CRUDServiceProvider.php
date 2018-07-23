<?php

namespace AmtTmg\CRUD;

use AmtTmg\CRUD\Commands\GenerateCrud;
use AmtTmg\CRUD\Commands\MakeCrudFile;
use Illuminate\Support\ServiceProvider;

class CRUDServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'amttmg');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'amttmg');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        //$this->loadRoutesFrom(__DIR__.'/routes/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {

            // Publishing the configuration file.
            $this->publishes([
                __DIR__.'/../config/crud.php' => config_path('crud.php'),
            ], 'crud.config');

            // Publishing the views.
           /* $this->publishes([
                __DIR__.'/resources/views' => base_path('resources/views'),
            ], 'crud.views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/amttmg'),
            ], 'crud.views');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/amttmg'),
            ], 'crud.views');*/

            // Registering package commands.
            $this->commands([
                GenerateCrud::class, MakeCrudFile::class
            ]);
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/crud.php', 'crud');

        // Register the service the package provides.
        $this->app->singleton('crud', function ($app) {
            return new CRUD;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['crud'];
    }
}
