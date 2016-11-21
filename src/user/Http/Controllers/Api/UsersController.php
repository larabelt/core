<?php

namespace Ohio\Core\User\Http\Controllers\Api;

use Illuminate\Http\Request;

use Ohio\Core\User;
use Ohio\Core\User\Http\Requests;
use Ohio\Core\Base\Http\Controllers\BaseApiController;

class UsersController extends BaseApiController
{

    /**
     * @var User\User
     */
    public $user;

    /**
     * ApiController constructor.
     * @param User\User $user
     */
    public function __construct(User\User $user)
    {
        $this->user = $user;
    }

    public function get($id)
    {
        return $this->user->find($id) ?: $this->abort(404);
    }

    /**
     * Display a listing of the resource.
     *
     * @param $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request = $this->getPaginateRequest(Requests\PaginateRequest::class, $request->query());

        $paginator = $this->getPaginator($this->user->query(), $request);

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
        $user = $this->user->create($request->all());

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
