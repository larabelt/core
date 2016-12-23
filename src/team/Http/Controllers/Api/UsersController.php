<?php

namespace Ohio\Core\Team\Http\Controllers\Api;

use Ohio\Core\Base\Http\Controllers\ApiController;
use Ohio\Core\Team\Team;
use Ohio\Core\Team\Http\Requests;
use Ohio\Core\User\User;

class UsersController extends ApiController
{

    /**
     * @var Team
     */
    public $teams;

    /**
     * @var User
     */
    public $users;

    /**
     * ApiController constructor.
     * @param Team $team
     * @param User $user
     */
    public function __construct(Team $team, User $user)
    {
        $this->teams = $team;
        $this->users = $user;
    }

    public function user($id, $team = null)
    {
        $user = $this->users->find($id) ?: $this->abort(404);

        if ($team && !$team->users->contains($id)) {
            $this->abort(400, 'team does not have this user');
        }

        return $user;
    }

    public function team($team_id)
    {
        $team = $this->teams->find($team_id);

        return $team ?: $this->abort(404);
    }

    /**
     * Display a listing of the resource.
     *
     * @param $request
     * @param  int $team_id
     * @return \Illuminate\Http\Response
     */
    public function index(Requests\PaginateUsers $request, $team_id)
    {

        $request->reCapture();

        $team = $this->team($team_id);

        $request->merge(['team_id' => $team->id]);

        $paginator = $this->paginator($this->users->query(), $request);

        return response()->json($paginator->toArray());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Requests\AttachUser $request
     * @param  int $team_id
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\AttachUser $request, $team_id)
    {
        $team = $this->team($team_id);

        $id = $request->get('id');

        if ($team->users->contains($id)) {
            $this->abort(422, ['id' => ['user already attached']]);
        }

        $team->users()->attach($id);

        return response()->json($this->user($id), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $team_id
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($team_id, $id)
    {
        $team = $this->team($team_id);

        $user = $this->user($id, $team);

        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $team_id
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($team_id, $id)
    {
        $team = $this->team($team_id);

        if (!$team->users->contains($id)) {
            $this->abort(422, ['id' => ['user not attached']]);
        }

        $team->users()->detach($id);

        return response()->json(null, 204);
    }

}
