<?php

namespace Belt\Core\Http\ViewComposers;

use Belt\Core\Services\ActiveTeamService;
use Illuminate\Contracts\View\View;

class ActiveTeamComposer
{

    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('team', ActiveTeamService::team());
    }

}