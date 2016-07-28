<?php

namespace Ohio\Base;

//use Ohio\Base\Console\Commands;
use Illuminate\Support\ServiceProvider;
use Prettus\Repository\Providers\RepositoryServiceProvider;

class OhioBaseServiceProvider extends ServiceProvider
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

        /*
         * Register other vendor providers
         */
        $this->app->register(RepositoryServiceProvider::class, [
            
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
            __DIR__ . '/../resources/sass/' => resource_path('sass')
        ], 'sass');

    }

}