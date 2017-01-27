<?php

namespace Ohio\Core\Base;

use Ohio;
use Barryvdh, Collective, Illuminate;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Router;
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
        include __DIR__ . '/../../routes/admin.php';
        include __DIR__ . '/../../routes/api.php';
        include __DIR__ . '/../../routes/manage.php';
        include __DIR__ . '/../../routes/web.php';
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(GateContract $gate, Router $router)
    {

        //$this->publishes([__DIR__ . '/../../resources' => resource_path('ohio/core')]);
        //$this->publishes([__DIR__ . '/../../database/factories' => database_path('factories')]);
        //$this->publishes([__DIR__ . '/../../database/migrations' => database_path('migrations')]);
        //$this->publishes([__DIR__ . '/../../database/seeds' => database_path('seeds')]);

        // set view paths
        $this->loadViewsFrom(resource_path('ohio/core/views'), 'ohio-core');

        // set backup view paths
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'ohio-core');

        // policies
        $this->registerPolicies($gate);

//        // middleware
//        $router->aliasMiddleware('ohio.guest', Ohio\Core\Base\Http\Middleware\RedirectIfAuthenticated::class);
//        $router->aliasMiddleware('ohio.throttle', Illuminate\Routing\Middleware\ThrottleRequests::class);
//        $router->middlewareGroup('ohio.web', [
//            Illuminate\Cookie\Middleware\EncryptCookies::class,
//            Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
//            Illuminate\Session\Middleware\StartSession::class,
//            Illuminate\View\Middleware\ShareErrorsFromSession::class,
//            Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
//            Illuminate\Routing\Middleware\SubstituteBindings::class,
//        ]);
//        $router->middlewareGroup('ohio.admin', [
//            'ohio.web',
//            Ohio\Core\Base\Http\Middleware\AdminAuthorize::class
//        ]);
//        $router->middlewareGroup('ohio.api', [
//            'ohio.throttle:60,1',
//        ]);
//        $router->middlewareGroup('ohio.api.admin', [
//            Illuminate\Cookie\Middleware\EncryptCookies::class,
//            Illuminate\Session\Middleware\StartSession::class,
//            'ohio.api',
//            Ohio\Core\Base\Http\Middleware\ApiAuthorize::class
//        ]);

        // commands
        $this->commands(Ohio\Core\Base\Commands\PublishCommand::class);
        $this->commands(Ohio\Core\Base\Commands\TestDBCommand::class);

        // morphMap
        Relation::morphMap([
            'roles' => Ohio\Core\Role\Role::class,
            'teams' => Ohio\Core\Team\Team::class,
            'users' => Ohio\Core\User\User::class,
        ]);

        // add sluggable behavior
        $this->app['events']->listen('eloquent.saving*', function ($eventName, array $data) {
            foreach($data as $model) {
                if (in_array(Ohio\Core\Base\Behaviors\SluggableTrait::class, class_uses($model))) {
                    $model->slugify();
                }
            }
        });

        // load other packages
        $this->app->register(Collective\Html\HtmlServiceProvider::class);
        if (env('APP_ENV') == 'local') {
            $this->app->register(Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }

        // add other aliases
        $loader = AliasLoader::getInstance();
        $loader->alias('Form', Collective\Html\FormFacade::class);
        $loader->alias('Html', Collective\Html\HtmlFacade::class);
    }

    /**
     * Register the application's policies.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate $gate
     * @return void
     */
    public function registerPolicies(GateContract $gate)
    {
//        $gate->before(function ($user, $ability) {
//            if ($user->hasRole('SUPER')) {
//                return true;
//            }
//        });
//
//        foreach ($this->policies as $key => $value) {
//            $gate->policy($key, $value);
//        }
    }

}