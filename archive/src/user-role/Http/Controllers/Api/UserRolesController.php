<?php

namespace Ohio\Core\UserRole\Http\Controllers\Api;

use Illuminate\Http\Request;

use Ohio\Core\UserRole;
use Ohio\Core\UserRole\Http\Requests;
use Ohio\Core\Base\Http\Controllers\ApiController;

class UserRolesController extends ApiController
{

    /**
     * @var UserRole\UserRole
     */
    public $userRole;

    /**
     * ApiController constructor.
     * @param UserRole\UserRole $userRole
     */
    public function __construct(UserRole\UserRole $userRole)
    {
        $this->userRole = $userRole;
    }

    public function get($id)
    {
        return $this->userRole->find($id) ?: $this->abort(404);
    }

    /**
     * Display a listing of the resource.
     *
     * @param $request
     * @return \Illuminate\Http\Response
     */
    public function index(Requests\PaginateUserRoles $request)
    {
        $request->reCapture();

        $qb = $this->userRole->query();
        $qb->with('role');

        $paginator = $this->paginator($qb, $request);

        return response()->json($paginator->toArray());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Requests\StoreUserRole $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\StoreUserRole $request)
    {

        $userRole = $this->userRole->create($request->all());

        return response()->json($userRole);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->get($id);

        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = $this->get($id);

        $user->delete();

        return response()->json(null, 204);
    }
}
