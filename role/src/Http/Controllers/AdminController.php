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

//        $response = parent::index($request);
//
//        if ($response->getStatusCode() != 200) {
//            return $this->redirect('/admin/dashboard');
//        }
//
//        $roles = json_decode(json_encode($this->data));
//
//        $paginator = new LengthAwarePaginator(
//            array_get($this->data, 'data'),
//            array_get($this->data, 'meta.pagination.total'),
//            array_get($this->data, 'meta.pagination.perPage'),
//            array_get($this->data, 'meta.pagination.page')
//        );

        //app(Ohio\Core\Base\Service\NgService::class)->push('/ng/roles.js');

        return View::make('roles::admin.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @param $request
     * @return \Illuminate\Http\Response
     */
    public function indexVue(Request $request)
    {

        return View::make('roles::admin.index-vue');
    }

    public function show($id)
    {
        $response = parent::show($id);

        if ($response->getStatusCode() != 200) {
            return $this->redirect('/admin/dashboard');
        }

        $role = json_decode(json_encode($this->data))->data;

        return View::make('roles::admin.show', compact('role'));
    }

}