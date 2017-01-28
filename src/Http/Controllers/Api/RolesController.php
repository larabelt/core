<?php

namespace Ohio\Core\Http\Controllers\Api;

use Ohio\Core\Http\Controllers\ApiController;
use Ohio\Core\Role;
use Ohio\Core\Http\Requests;

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
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Requests\PaginateRoles $request)
    {
        $paginator = $this->paginator($this->roles->query(), $request->reCapture());

        return response()->json($paginator->toArray());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Requests\StoreRole $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Requests\StoreRole $request)
    {

        $input = $request->all();

        $role = $this->roles->create(['name' => $input['name']]);

        $this->set($role, $input, [
            'slug',
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

        return response()->json($role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Requests\UpdateRole $request
     * @param  string $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Requests\UpdateRole $request, $id)
    {
        $role = $this->get($id);

        $input = $request->all();

        $this->set($role, $input, [
            'name',
            'slug',
        ]);

        $role->save();

        return response()->json($role);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $role = $this->get($id);

        $role->delete();

        return response()->json(null, 204);
    }
}
