<?php

namespace Belt\Core;

use Belt, Barryvdh, Collective, Event, Illuminate, Laravel, Rap2hpoutre;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

/**
 * Class BeltCoreServiceProvider
 * @package Belt\Core
 */
class BeltCoreServiceProvider extends ServiceProvider
{

    /**
     * The Larabelt toolkit version.
     *
     * @var string
     */
    const VERSION = '1.4.63';

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Belt\Core\User::class => Belt\Core\Policies\UserPolicy::class,
        Belt\Core\Role::class => Belt\Core\Policies\RolePolicy::class,
        Belt\Core\Team::class => Belt\Core\Policies\TeamPolicy::class,
    ];

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        include __DIR__ . '/../routes/admin.php';
        include __DIR__ . '/../routes/api.php';
        include __DIR__ . '/../routes/manage.php';
        include __DIR__ . '/../routes/web/base.php';
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(GateContract $gate, Router $router)
    {

        // set backup view paths
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'belt-core');

        // policies
        $this->registerPolicies($gate);

        // commands
        $this->commands(Belt\Core\Commands\AlertCommand::class);
        $this->commands(Belt\Core\Commands\BeltCommand::class);
        $this->commands(Belt\Core\Commands\PublishCommand::class);
        $this->commands(Belt\Core\Commands\TestDBCommand::class);
        $this->commands(Belt\Core\Commands\UpdateCommand::class);

        // events
        Event::subscribe(Belt\Core\Listeners\UserEventSubscriber::class);
        Event::subscribe(Belt\Core\Listeners\TeamEventSubscriber::class);

        // observers
        Belt\Core\Team::observe(Belt\Core\Observers\TeamObserver::class);
        Belt\Core\User::observe(Belt\Core\Observers\UserObserver::class);

        // morphMap
        Relation::morphMap([
            'params' => Belt\Core\Param::class,
            'roles' => Belt\Core\Role::class,
            'teams' => Belt\Core\Team::class,
            'users' => Belt\Core\User::class,
        ]);

        // route model binding
        $router->model('alert', Belt\Core\Alert::class, function ($value) {
            return Belt\Core\Alert::sluggish($value)->first();
        });
        $router->model('user', Belt\Core\User::class);

        // add alias/facade
        $loader = AliasLoader::getInstance();
        $loader->alias('Debugbar', Barryvdh\Debugbar\Facade::class);
        $loader->alias('Form', Collective\Html\FormFacade::class);
        $loader->alias('Html', Collective\Html\HtmlFacade::class);
        $loader->alias('Morph', Belt\Core\Facades\MorphFacade::class);

        // bind for facade
        $this->app->bind('morph', function ($app) {
            return new Belt\Core\Helpers\MorphHelper();
        });

        // beltable values for global belt command
        $this->app->singleton('belt', 'Belt\Core\BeltSingleton');
        $this->app['belt']->publish('belt-core:publish');
        $this->app['belt']->seeders('BeltCoreSeeder');

        // view composers
        view()->composer(['*layouts.admin.*'], Belt\Core\Http\ViewComposers\ActiveTeamComposer::class);
        view()->composer(['*window-config'], Belt\Core\Http\ViewComposers\WindowConfigComposer::class);

        // load other packages
        $this->app->register(Collective\Html\HtmlServiceProvider::class);
        $this->app->register(Barryvdh\Cors\ServiceProvider::class);
        if (env('APP_DEBUG') === true) {
            $this->app->register(Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
            $this->app->register(Barryvdh\Debugbar\ServiceProvider::class);
            $this->app->register(Rap2hpoutre\LaravelLogViewer\LaravelLogViewerServiceProvider::class);
        }
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
            if ($user->is_super) {
                return true;
            }
        });

        foreach ($this->policies as $key => $value) {
            $gate->policy($key, $value);
        }
    }

}