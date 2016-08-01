<?php

namespace Ohio\Core\Base;

use Ohio, View;
use Illuminate\Routing\Router;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Support\ServiceProvider;
use Prettus\Repository\Providers\RepositoryServiceProvider;

class OhioCoreServiceProvider extends ServiceProvider
{

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [];

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        include __DIR__ . '/Base/Http/routes.php';
        include __DIR__ . '/User/Http/routes.php';
        include __DIR__ . '/Role/Http/routes.php';
        include __DIR__ . '/UserRole/Http/routes.php';

        $this->commands([
            Base\Console\Commands\ClearCommand::class,
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
    public function boot(GateContract $gate, Router $router)
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/layouts', 'layout');
        $this->loadViewsFrom(__DIR__ . '/../resources/views/core', 'core');
        $this->loadViewsFrom(__DIR__ . '/../resources/views/users', 'users');
        $this->loadViewsFrom(__DIR__ . '/../resources/views/roles', 'roles');

        $this->publishes([__DIR__ . '/../resources/sass/' => resource_path('sass')], 'sass');
        $this->publishes([__DIR__ . '/../database/factories/' => database_path('factories')], 'factories');
        $this->publishes([__DIR__ . '/../database/migrations/' => database_path('migrations')], 'migrations');
        $this->publishes([__DIR__ . '/../database/seeds/' => database_path('seeds')], 'seeds');

        $this->registerPolicies($gate);

        $router->middleware('auth.admin', Base\Http\Middleware\AdminAuthenticate::class);

        View::composer(['layout::admin.partials.scripts-body-close'], Base\Composer\NgComposer::class);

    }

    /**
     * Register the application's policies.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate $gate
     * @return void
     */
    public function registerPolicies(GateContract $gate)
    {
        $gate->before(function ($user, $ability) {
            if ($user->hasRole('SUPER')) {
                return true;
            }
        });

        foreach ($this->policies as $key => $value) {
            $gate->policy($key, $value);
        }

        $this->app->singleton(Base\Service\NgService::class);
    }

}