<?php

namespace Ohio\Core\Base;

use Ohio\Core;
use Ohio\Core\Role;
use Illuminate\Routing\Router;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Support\ServiceProvider;

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
        include __DIR__ . '/Http/routes.php';
        include __DIR__ . '/../role/Http/routes.php';
        include __DIR__ . '/../user/Http/routes.php';
        include __DIR__ . '/../user-role/Http/routes.php';
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(GateContract $gate, Router $router)
    {

        // publish client
        $this->publishes([__DIR__ . '/../../client' => base_path('ohio/core/client')]);

        // publish resources
        $this->publishes([__DIR__ . '/../../resources' => base_path('ohio/core/resources')]);

        // database
        $this->publishes([__DIR__ . '/../../database/factories' => database_path('factories')]);
        $this->publishes([__DIR__ . '/../../database/migrations' => database_path('migrations')]);
        $this->publishes([__DIR__ . '/../../database/seeds' => database_path('seeds')]);

        // set view paths
        $this->loadViewsFrom(base_path('ohio/core/resources/views'), 'ohio-core');

        // set backup view paths
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'ohio-core');

        $this->registerPolicies($gate);

        $router->middleware('auth.admin', Core\Base\Http\Middleware\AdminAuthenticate::class);

        Role\Role::observe(Role\Observers\RoleObserver::class);

        $this->commands(Core\Base\Commands\AssetsCommand::class);
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
    }

}