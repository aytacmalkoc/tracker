<?php

namespace Aytacmalkoc\Tracker;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class TrackerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->bladeDirectives();

        Route::group(['middleware' => ['web']], function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('tracker.php'),
            ], 'tracker::config');

            // Publishing assets.
            $this->publishes([
                __DIR__.'/../public' => public_path('vendor/tracker'),
            ], 'tracker::assets');
        }

        $this->app->make('config')->set('logging.channels.tracker', config('tracker.logging'));
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'tracker');

        // Register the main class to use with the facade
        $this->app->singleton('tracker', function () {
            return new Tracker;
        });
    }

    public function bladeDirectives(): void
    {
        Blade::directive('trackerScript', function () {
            $manifest = json_decode(file_get_contents(public_path('vendor/tracker/manifest.json')), true);
            $jsFile = $manifest['resources/js/tracker.js']['file'];
            $path = asset("vendor/tracker/$jsFile");

            return "<script type='module' src='$path' async></script>";
        });
    }
}
