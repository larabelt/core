<?php

namespace Belt\Core\Http\ViewComposers;

use Belt, Auth, Cache, Route, Translate;
use Belt\Core\Helpers\WindowConfigHelper;
use Belt\Core\Services\AccessService;
use Belt\Core\Services\ActiveTeamService;
use Illuminate\Contracts\View\View;

class WindowConfigComposer
{

    /**
     * @var array
     */
    public $middleware = [];

    /**
     * WindowConfigComposer constructor.
     */
    public function __construct()
    {
        $this->middleware();
        $this->setup();
    }

    /**
     * @return array
     */
    public function middleware()
    {
        if (!$this->middleware && $route = Route::current()) {
            $this->middleware = $route->middleware();
        }

        return $this->middleware;
    }

    /**
     * Run default WindowConfig options.
     */
    public function setup()
    {
        // auth user
        $user = Auth::user();
        if ($user) {
            WindowConfigHelper::put('auth', [
                'id' => $user->id,
                'super' => $user->super(),
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'username' => $user->username,
                'roles' => $user->roles->pluck('name')->toArray(),
                'teams' => $user->teams->pluck('id')->toArray(),
            ]);
        }

        // team
        $activeTeam = ActiveTeamService::team();
        WindowConfigHelper::put('activeTeam', $activeTeam);

        // mode
        $mode = 'web';
        if (in_array('admin', $this->middleware)) {
            $mode = 'admin';
        }
        $mode = $activeTeam ? 'team' : $mode;
        WindowConfigHelper::put('adminMode', $mode);

        // coords
        WindowConfigHelper::put('coords', [
            'google_api_key' => env('GOOGLE_API_KEY'),
            'lat' => env('COORDS_LAT', 39.9612),
            'lng' => env('COORDS_LNG', -82.9988),
            'zoom' => env('COORDS_ZOOM', 17),
        ]);

        // access
        WindowConfigHelper::put('access', (new AccessService())->map());

        // docs
        WindowConfigHelper::put('docs', config('belt.docs'));

        // locale / translate
        WindowConfigHelper::put('locale', Translate::getLocale());
        WindowConfigHelper::put('fallback_locale', config('app.fallback_locale'));
        WindowConfigHelper::put('locales', config('belt.core.translate.locales'));
        WindowConfigHelper::put('translate.auto-translate', (bool) config('belt.core.translate.auto-translate'));
        //WindowConfigHelper::put('alt-locale', Translate::getAlternateLocale());
        //WindowConfigHelper::put('translate', config('belt.core.translate'));
    }

    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('windowConfig', WindowConfigHelper::json());
    }

}