<?php

namespace Belt\Core\Http\ViewComposers;

use Belt\Core\Role;
use Belt\Core\Services\ActiveTeamService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class UserRolesComposer
{

    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @var Role $role
     * @return void
     */
    public function compose(View $view)
    {
        $roles = [];

        if( Auth::user() ) {
            foreach(Auth::user()->roles as $role) {
                $roles[$role->name] = $role->title;
            }
        }

        $view->with('user_role_names', $roles);
    }

}