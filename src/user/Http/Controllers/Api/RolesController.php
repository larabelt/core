<?php

namespace Ohio\Core\User\Http\Controllers\Api;

use Ohio\Core\Base\Http\Controllers\ApiController;
use Ohio\Core\Role\Role;
use Ohio\Core\User\User;
use Ohio\Core\User\Http\Requests;
use Illuminate\Http\Request;

class RolesController extends ApiController
{

    /**
     * @var Role
     */
    public $roles;

    /**
     * @var User
     */
    public $users;

    public function __construct(User $user, Role $role)
    {
        $this->roles = $role;
        $this->users = $user;
    }

    public function role($id, $user = null)
    {
        $role = $this->roles->find($id) ?: $this->abort(404);

        if ($user && !$user->roles->contains($id)) {
            $this->abort(400, 'user does not have this role');
        }

        return $role;
    }

    public function user($user_id)
    {
        $user = $this->users->find($user_id);

        return $user ?: $this->abort(404);
    }

    /**
     * Display a listing of the resource.
     *
     * @param $request
     * @param  int $user_id
     * @return \Illuminate\Http\Response
     */
    public function index(Requests\PaginateRoles $request, $user_id)
    {

        $request->reCapture();

        $user = $this->user($user_id);

        $request->merge(['user_id' => $user->id]);

        $paginator = $this->paginator($this->roles->query(), $request);

        return response()->json($paginator->toArray());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Requests\AttachRole $request
     * @param  int $user_id
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\AttachRole $request, $user_id)
    {
        $user = $this->user($user_id);

        $id = $request->get('id');

        if ($user->roles->contains($id)) {
            $this->abort(422, ['id' => ['role already attached']]);
        }

        $user->roles()->attach($id);

        return response()->json($this->role($id), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $user_id
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($user_id, $id)
    {
        $user = $this->user($user_id);

        $role = $this->role($id, $user);

        return response()->json($role);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $user_id
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($user_id, $id)
    {
        $user = $this->user($user_id);

        if (!$user->roles->contains($id)) {
            $this->abort(422, ['id' => ['role not attached']]);
        }

        $user->roles()->detach($id);

        return response()->json(null, 204);
    }
}
