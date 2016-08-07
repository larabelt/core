<?php namespace Ohio\Core\Base\Http\Controllers;

use Auth, Gate;
use Illuminate\Http\Request;
use Ohio\Core\Base\Http\Controllers\BaseController;

class AdminController extends BaseController
{

    /**
     * Display dashboard
     *
     * @return Response
     */
    public function getIndex()
    {

        if (Gate::denies('admin-index')) {
            //abort(403);
            //s(403);
        }

        return view('layouts::admin.dashboard');
    }

}