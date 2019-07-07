<?php

namespace Tjventurini\VoyagerCMS;

use Illuminate\Events\Dispatcher;
use Illuminate\Support\ServiceProvider;
use Tjventurini\VoyagerCMS\Console\Commands\VoyagerCMSInstall;

class VoyagerCMSServiceProvider extends ServiceProvider
{
    /**
     * Boot method of this service provider.
     *
     * @return void
     */
    public function boot()
    {
        // tell laravel where to find the migrations.
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations/');

        // tell laravel where to publish config if the user wants it to
        $this->publishes([
            __DIR__.'/../config' => config_path(),
        ], 'config');

        // tell laravel where to find the views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'cms');

        // tell laravel where to publish views
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/voyager/cms'),
        ], 'views');

        // tell laravel where to find translations
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'cms');

        // tell laravel where to publish package translations
        $this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/cms'),
        ], 'lang');

        // tell laravel where to publish package graphql schema
        $this->publishes([
            __DIR__.'/../graphql' => base_path('graphql'),
        ], 'graphql');

        // tell laravel where to find routes
        $this->loadRoutesFrom(__DIR__.'/../routes/routes.php');

        // register commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                VoyagerCMSInstall::class,
            ]);
        }
    }

    /**
     * Register method of this service provider.
     *
     * @return void
     */
    public function register()
    {
    }
}
