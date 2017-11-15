<?php

namespace Belt\Core\Http\Controllers\Web;

use Belt;
use Belt\Core\Http\Controllers\BaseController;

/**
 * Class TeamsController
 * @package Belt\Core\Http\Controllers\Web
 */
class TeamsController extends BaseController
{
    use Belt\Core\Http\Controllers\Behaviors\Content;

    /**
     * Display team signup form
     *
     * @return \Illuminate\View\View
     */
    public function signup()
    {
        $page = $this->contentPage('teams-web-signup');

        return view('belt-core::teams.web.signup', compact('page'));
    }

    /**
     * Display team welcome page
     *
     * @return \Illuminate\View\View
     */
    public function welcome()
    {
        $page = $this->contentPage('teams-web-welcome');

        return view('belt-core::teams.web.welcome', compact('page'));
    }

}