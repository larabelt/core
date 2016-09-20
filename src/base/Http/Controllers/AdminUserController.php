<?php namespace Ohio\Core\Base\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Ohio\Core\Base\Http\Controllers\BaseController;

class AdminUserController extends BaseController
{

    /**
     * Display dashboard
     *
     * @return Response
     */
    public function getIndex()
    {
        return view('ohio-core::layouts.admin-user.index');
    }

}