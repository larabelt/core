<?php

namespace Belt\Core\Http\Controllers\Web;

use Belt\Core\Http\Controllers\BaseController;

/**
 * Class UsersController
 * @package Belt\Core\Http\Controllers\Web
 */
class UsersController extends BaseController
{

    /**
     * Display user signup form
     *
     * @return \Illuminate\View\View
     */
    public function signup()
    {
        return view('belt-core::users.web.signup');
    }

    /**
     * Display user welcome page
     *
     * @return \Illuminate\View\View
     */
    public function welcome()
    {
        return view('belt-core::users.web.welcome');
    }

}