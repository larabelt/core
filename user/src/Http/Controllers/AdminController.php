<?php

namespace Ohio\Core\User\Http\Controllers;

use Ohio, View;
use Ohio\Core\User;
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

        return View::make('users::admin.index');

//        $response = parent::index($request);
//
//        if ($response->getStatusCode() != 200) {
//            return $this->redirect('/admin/dashboard');
//        }
//
//        $users = json_decode(json_encode($this->data));
//
//        $paginator = new LengthAwarePaginator(
//            array_get($this->data, 'data'),
//            array_get($this->data, 'meta.pagination.total'),
//            array_get($this->data, 'meta.pagination.perPage'),
//            array_get($this->data, 'meta.pagination.page')
//        );

        //app(Ohio\Core\Service\NgService::class)->push('/ng/users.js');

        return View::make('users::admin.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @param $request
     * @return \Illuminate\Http\Response
     */
    public function indexVue(Request $request)
    {

        return View::make('users::admin.index-vue');
    }

    public function show($id)
    {
        $response = parent::show($id);

        if ($response->getStatusCode() != 200) {
            return $this->redirect('/admin/dashboard');
        }

        $user = json_decode(json_encode($this->data))->data;

        return View::make('users::admin.show', compact('user'));
    }

}