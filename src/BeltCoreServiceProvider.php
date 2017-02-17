<?php

namespace Belt\Core;

use Belt;
use Barryvdh, Collective, Illuminate, Rap2hpoutre;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class BeltCoreServiceProvider extends ServiceProvider
{

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
        include __DIR__ . '/../routes/web.php';
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(GateContract $gate, Router $router)
    {

        //$this->publishes([__DIR__ . '/../../resources' => resource_path('belt/core')]);
        //$this->publishes([__DIR__ . '/../../database/factories' => database_path('factories')]);
        //$this->publishes([__DIR__ . '/../../database/migrations' => database_path('migrations')]);
        //$this->publishes([__DIR__ . '/../../database/seeds' => database_path('seeds')]);

        // set view paths
        // $this->loadViewsFrom(resource_path('belt/core/views'), 'belt-core');

        // set backup view paths
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'belt-core');

        // policies
        $this->registerPolicies($gate);

        // commands
        $this->commands(Belt\Core\Commands\PublishCommand::class);
        $this->commands(Belt\Core\Commands\TestDBCommand::class);

        // morphMap
        Relation::morphMap([
            'params' => Belt\Core\Param::class,
            'roles' => Belt\Core\Role::class,
            'teams' => Belt\Core\Team::class,
            'users' => Belt\Core\User::class,
        ]);

        // add sluggable behavior
        $this->app['events']->listen('eloquent.saving*', function ($eventName, array $data) {
            foreach ($data as $model) {
                //if (in_array(Belt\Core\Behaviors\Sluggable::class, class_uses($model))) {
                if ($model instanceof Belt\Core\Behaviors\SluggableInterface) {
                    $model->slugify();
                }
            }
        });

        // load other packages
        $this->app->register(Collective\Html\HtmlServiceProvider::class);
        if (env('APP_ENV') == 'local') {
            $this->app->register(Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
            $this->app->register(Barryvdh\Debugbar\ServiceProvider::class);
            $this->app->register(Rap2hpoutre\LaravelLogViewer\LaravelLogViewerServiceProvider::class);
        }

        // add other aliases
        $loader = AliasLoader::getInstance();
        $loader->alias('Debugbar', Barryvdh\Debugbar\Facade::class);
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