<?php

namespace Belt\Core\Http\Controllers\Api;

use Belt\Core\User;
use Belt\Core\Http\Requests;
use Belt\Core\Http\Controllers\ApiController;

class UsersController extends ApiController
{

    /**
     * The repository instance.
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Requests\PaginateUsers $request)
    {
        $this->authorize('index', User::class);

        $paginator = $this->paginator($this->users->query(), $request->reCapture());

        return response()->json($paginator->toArray());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Requests\StoreUser $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Requests\StoreUser $request)
    {

        $this->authorize('create', User::class);

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

        $user->save();

        return response()->json($user, 201);
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

        $user = $this->get($id);

        $this->authorize('view', $user);

        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Requests\UpdateUser $request
     * @param  string $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Requests\UpdateUser $request, $id)
    {
        $user = $this->get($id);

        $this->authorize('update', $user);

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
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $user = $this->get($id);

        $this->authorize('delete', $user);

        $user->delete();

        return response()->json(null, 204);
    }
}
