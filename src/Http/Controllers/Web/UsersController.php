<?php

namespace Belt\Core\Http\Controllers\Web;

use Belt;
use Belt\Core\Http\Controllers\BaseController;

/**
 * Class UsersController
 * @package Belt\Core\Http\Controllers\Web
 */
class UsersController extends BaseController
{
    use Belt\Core\Http\Controllers\Behaviors\Content;

    /**
     * Display user signup form
     *
     * @return \Illuminate\View\View
     */
    public function signup()
    {
        $page = $this->contentPage('users-web-signup');

        return view('belt-core::users.web.signup', compact('page'));
    }

    /**
     * Display user welcome page
     *
     * @return \Illuminate\View\View
     */
    public function welcome()
    {
        $page = $this->contentPage('users-web-welcome');

        return view('belt-core::users.web.welcome', compact('page'));
    }

}