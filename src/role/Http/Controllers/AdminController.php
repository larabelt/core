<?php

namespace Ohio\Core\Role\Http\Controllers;

use Ohio, View;
use Ohio\Core\Role;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class AdminController extends ApiController
{

    /**
     * Display a listing of the resource.
     *
     * @param $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return View::make('roles::admin.index');
    }

}