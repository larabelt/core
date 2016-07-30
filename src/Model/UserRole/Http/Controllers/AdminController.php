<?php

namespace Ohio\Core\Model\UserRole\Http\Controllers;

use Ohio, View;
use Ohio\Core\Model\UserRole\Domain;
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

        return View::make('users-roles::admin.index');

//        $response = parent::index($request);
//
//        if ($response->getStatusCode() != 200) {
//            return $this->redirect('/admin/dashboard');
//        }
//
//        $users_roles = json_decode(json_encode($this->data));
//
//        $paginator = new LengthAwarePaginator(
//            array_get($this->data, 'data'),
//            array_get($this->data, 'meta.pagination.total'),
//            array_get($this->data, 'meta.pagination.perPage'),
//            array_get($this->data, 'meta.pagination.page')
//        );

        //app(Ohio\Core\Base\Service\NgService::class)->push('/ng/users-roles.js');

        return View::make('users-roles::admin.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @param $request
     * @return \Illuminate\Http\Response
     */
    public function indexVue(Request $request)
    {

        return View::make('users-roles::admin.index-vue');
    }

    public function show($id)
    {
        $response = parent::show($id);

        if ($response->getStatusCode() != 200) {
            return $this->redirect('/admin/dashboard');
        }

        $userRole = json_decode(json_encode($this->data))->data;

        return View::make('users-roles::admin.show', compact('userRole'));
    }

}