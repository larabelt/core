<?php

namespace Belt\Core\Http\Controllers\Api;

use Belt\Core\Http\Controllers\ApiController;
use Belt\Core\Team;
use Belt\Core\Http\Requests;
use Belt\Core\User;
use Illuminate\Http\Request;

/**
 * Class TeamUsersController
 * @package Belt\Core\Http\Controllers\Api
 */
class TeamUsersController extends ApiController
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

    /**
     * @param $id
     * @param null $team
     */
    public function user($id, $team = null)
    {
        $user = $this->users->find($id) ?: $this->abort(404);

        if ($team && !$team->users->contains($id)) {
            $this->abort(404, 'team does not have this user');
        }

        return $user;
    }

    /**
     * @param $team_id
     */
    public function team($team_id)
    {
        $team = $this->teams->find($team_id);

        return $team ?: $this->abort(404);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param  int $team_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, $team_id)
    {
        $team = $this->team($team_id);

        $this->authorize(['view', 'create', 'update', 'delete'], $team);

        $request = Requests\PaginateTeamUsers::extend($request);

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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Requests\AttachUser $request, $team_id)
    {
        $team = $this->team($team_id);

        $this->authorize('update', $team);

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
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($team_id, $id)
    {
        $team = $this->team($team_id);

        $this->authorize(['view', 'create', 'update', 'delete'], $team);

        $user = $this->user($id, $team);

        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $team_id
     * @param  int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($team_id, $id)
    {
        $team = $this->team($team_id);

        $this->authorize('update', $team);

        $this->user($id, $team);

        $team->users()->detach($id);

        $team->touch();

        return response()->json(null, 204);
    }

}
