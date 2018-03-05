<?php

namespace Belt\Core\Http\Controllers\Api;

use Belt, Bouncer;
use Belt\Core\Http\Controllers\ApiController;
use Belt\Core\Role;
use Belt\Core\Http\Requests;
use Illuminate\Http\Request;

class RolesController extends ApiController
{

    /**
     * The repository instance.
     *
     * @var Role
     */
    public $roles;

    /**
     * ApiController constructor.
     * @param Role $role
     */
    public function __construct(Role $role)
    {
        $this->roles = $role;
    }

    public function get($id)
    {
        return $this->roles->find($id) ?: $this->abort(404);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('view', Role::class);

        $request = Requests\PaginateRoles::extend($request);

        $paginator = $this->paginator($this->roles->query(), $request);

        return response()->json($paginator->toArray());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Requests\StoreRole $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Requests\StoreRole $request)
    {
        $this->authorize('create', Role::class);

        $input = $request->all();

        $role = $this->roles->create(['name' => $input['name']]);

        $this->set($role, $input, [
            'title',
            'level',
            'scope',
            'description',
        ]);

        $role->save();

        return response()->json($role, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {

        $role = $this->get($id);

        $this->authorize('view', $role);

        return response()->json($role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Requests\UpdateRole $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Requests\UpdateRole $request, $id)
    {
        $role = $this->get($id);

        $this->authorize('update', $role);

        $input = $request->all();

        $this->set($role, $input, [
            'name',
            'title',
            'level',
            'scope',
            'description',
        ]);

        $role->save();

        return response()->json($role);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($id)
    {
        $role = $this->get($id);

        $this->authorize('delete', $role);

        $role->delete();

        return response()->json(null, 204);
    }
}
