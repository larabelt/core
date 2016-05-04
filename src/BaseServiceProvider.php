<?php

namespace Ohio\Base;

//use Ohio\Base\Console\Commands;
use Illuminate\Support\ServiceProvider;

class BaseServiceProvider extends ServiceProvider
{

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        include __DIR__ . '/Http/routes.php';

        $this->commands([
            Console\Commands\ClearCommand::class,
        ]);
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/layouts', 'layout');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'base');

        $this->publishes([
            __DIR__ . '/../resources/assets/sass/' => resource_path('assets/sass')
        ], 'sass');
    }

}