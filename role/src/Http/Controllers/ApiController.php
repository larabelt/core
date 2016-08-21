<?php

namespace Ohio\Core\Role\Http\Controllers;

use Illuminate\Http\Request;

use Ohio\Core\Base\Pagination\BaseLengthAwarePaginator;
use Ohio\Core\Role;
use Ohio\Core\Role\Http\Requests;
use Ohio\Core\Base\Http\Controllers\BaseApiController;

class ApiController extends BaseApiController
{

    private function get($id)
    {
        try {
            $role = Role\Role::findOrFail($id);
            return $role;
        } catch (\Exception $e) {
            abort(404, 'Record not found.');
        }

        return null;
    }

    /**
     * Display a listing of the resource.
     *
     * @param $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request = new Requests\PaginateRequest($request->query());

        $paginator = BaseLengthAwarePaginator::get(Role\Role::query(), $request);

        return response()->json($paginator);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Requests\CreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\CreateRequest $request)
    {

        $role = Role\Role::create($request->all());

        return response()->json($role);
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
        $role = $this->get($id);

        return response()->json($role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Requests\UpdateRequest $request
     * @param  string $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\UpdateRequest $request, $id)
    {
        $role = $this->get($id);

        $role->update($request->all());

        return response()->json($role);
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
        $role = $this->get($id);

        $role->delete();

        return response()->json(null, 204);
    }
}
