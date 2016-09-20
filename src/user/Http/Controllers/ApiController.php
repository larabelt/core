<?php

namespace Ohio\Core\User\Http\Controllers;

use Illuminate\Http\Request;

use Ohio\Core\Base\Pagination\BaseLengthAwarePaginator;
use Ohio\Core\User;
use Ohio\Core\User\Http\Requests;
use Ohio\Core\Base\Http\Controllers\BaseApiController;

class ApiController extends BaseApiController
{

    private function get($id)
    {
        try {
            $user = User\User::findOrFail($id);
            return $user;
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

        $paginator = new BaseLengthAwarePaginator(User\User::query(), $request);

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

        $user = User\User::create($request->all());

        return response()->json($user);
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
     * Update the specified resource in storage.
     *
     * @param  Requests\UpdateRequest $request
     * @param  string $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\UpdateRequest $request, $id)
    {
        $user = $this->get($id);

        $user->update($request->all());

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
