<?php

namespace Ohio\Core\Base;

use View;
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
        include __DIR__ . '/../../role/src/Http/routes.php';
        include __DIR__ . '/../../user/src/Http/routes.php';
        include __DIR__ . '/../../user-role/src/Http/routes.php';
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(GateContract $gate, Router $router)
    {

        // publish view files
        $this->publishes([__DIR__ . '/../../base/resources/' => resource_path('ohio/core/base')]);
        $this->publishes([__DIR__ . '/../../role/resources/' => resource_path('ohio/core/role')]);
        $this->publishes([__DIR__ . '/../../user/resources/' => resource_path('ohio/core/user')]);

//        $this->publishes([
//            __DIR__ . '/../resources/sass/' => resource_path('sass'),
//        ], 'sass');

        // factories
        $this->publishes([
            __DIR__ . '/../../role/database/factories/' => database_path('factories'),
            __DIR__ . '/../../user/database/factories/' => database_path('factories'),
            __DIR__ . '/../../user-role/database/factories/' => database_path('factories'),
        ], 'factories');

        // migrations
        $this->publishes([
            __DIR__ . '/../../role/database/migrations/' => database_path('migrations'),
            __DIR__ . '/../../user/database/migrations/' => database_path('migrations'),
            __DIR__ . '/../../user-role/database/migrations/' => database_path('migrations'),
        ], 'migrations');

        // seeds
        $this->publishes([
            __DIR__ . '/../../role/database/seeds/' => database_path('seeds'),
            __DIR__ . '/../../user/database/seeds/' => database_path('seeds'),
            __DIR__ . '/../../user-role/database/seeds/' => database_path('seeds'),
        ], 'seeds');

        // set view paths
        $this->loadViewsFrom(resource_path('ohio/core/base/layouts'), 'layouts');
        $this->loadViewsFrom(resource_path('ohio/core/base/views'), 'core');
        $this->loadViewsFrom(resource_path('ohio/core/base/roles'), 'roles');
        $this->loadViewsFrom(resource_path('ohio/core/base/users'), 'users');

        // set backup view paths
        $this->loadViewsFrom(__DIR__ . '/../../base/resources/layouts', 'layouts');
        $this->loadViewsFrom(__DIR__ . '/../../base/resources/views', 'core');
        $this->loadViewsFrom(__DIR__ . '/../../role/resources/views', 'roles');
        $this->loadViewsFrom(__DIR__ . '/../../user/resources/views', 'users');

        $this->registerPolicies($gate);

        $router->middleware('auth.admin', Core\Base\Http\Middleware\AdminAuthenticate::class);

        Role\Role::observe(Role\Observers\RoleObserver::class);
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