<?php

namespace Ohio\Core\User\Http\Controllers\Api;

use Illuminate\Http\Request;

use Ohio\Core\User\User;
use Ohio\Core\User\Http\Requests;
use Ohio\Core\Base\Http\Controllers\BaseApiController;

class UsersController extends BaseApiController
{

    /**
     * The user repository instance.
     *
     * @var User
     */
    public $users;

    /**
     * ApiController constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->users = $user;
    }

    public function get($id)
    {
        return $this->users->find($id) ?: $this->abort(404);
    }

    /**
     * Display a listing of the resource.
     *
     * @param $request
     * @return \Illuminate\Http\Response
     */
    public function index(Requests\PaginateUsers $request)
    {

        $request->reCapture();

        $paginator = $this->paginator($this->users->query(), $request);

        return response()->json($paginator->toArray());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Requests\StoreUser $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\StoreUser $request)
    {

        $input = $request->all();

        $user = $this->users->create(['email' => $input['email']]);

        $this->set($user, $input, [
            'is_active',
            'is_verified',
            'first_name',
            'last_name',
            'mi',
            'password',
        ]);

        return response()->json($user, 201);
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
     * @param  Requests\UpdateUser $request
     * @param  string $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\UpdateUser $request, $id)
    {
        $user = $this->get($id);

        $input = $request->all();

        $this->set($user, $input, [
            'is_active',
            'is_verified',
            'first_name',
            'last_name',
            'mi',
            'email',
            'password',
        ]);

        $user->save();

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
