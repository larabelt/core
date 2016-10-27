<?php

namespace Ohio\Core\UserRole\Http\Controllers;

use Illuminate\Http\Request;

use Ohio\Core\UserRole;
use Ohio\Core\UserRole\Http\Requests;
use Ohio\Core\Base\Pagination\BaseLengthAwarePaginator;
use Ohio\Core\Base\Http\Controllers\BaseApiController;

class ApiController extends BaseApiController
{

    private function get($id)
    {
        try {
            $userRole = UserRole\UserRole::findOrFail($id);
            return $userRole;
        } catch (\Exception $e) {
            $this->abort(404);
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

        $qb = UserRole\UserRole::query();
        $qb->with('role');

        $paginator = new BaseLengthAwarePaginator($qb, $request);

        return response()->json($paginator->toArray());
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

        $userRole = UserRole\UserRole::create($request->all());

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
