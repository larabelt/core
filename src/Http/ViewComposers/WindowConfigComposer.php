<?php

namespace Belt\Core\Http\ViewComposers;

use Belt, Auth, Route;
use Belt\Core\Helpers\WindowConfigHelper;
use Belt\Core\Services\ActiveTeamService;
use Illuminate\Contracts\View\View;

class WindowConfigComposer
{

    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {
        $route = $this->route();

        // auth user
        $user = Auth::user();
        WindowConfigHelper::put('auth', [
            'is_super' => $user->is_super,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'username' => $user->username,
            'roles' => $user->roles->pluck('name')->toArray(),
            'teams' => $user->teams->pluck('id')->toArray(),
        ]);

        // team
        $activeTeam = ActiveTeamService::team();
        WindowConfigHelper::put('activeTeam', $activeTeam);

        // mode
        $mode = 'web';
        if (in_array('admin', $route->middleware())) {
            $mode = 'admin';
        }
        $mode = $activeTeam ? 'team' : $mode;
        WindowConfigHelper::put('adminMode', $mode);

        // coords
        WindowConfigHelper::put('coords', [
            'gmaps_api_key' => env('GMAPS_API_KEY'),
            'lat' => env('COORDS_LAT', 39.9612),
            'lng' => env('COORDS_LNG', -82.9988),
            'zoom' => env('COORDS_ZOOM', 17),
        ]);

        $view->with('windowConfig', WindowConfigHelper::json());
    }

    public function route()
    {
        return Route::current();
    }

}