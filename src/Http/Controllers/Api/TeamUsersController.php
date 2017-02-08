<?php

namespace Ohio\Core\Http\Controllers\Api;

use Ohio\Core\Http\Controllers\ApiController;
use Ohio\Core\Team;
use Ohio\Core\Http\Requests;
use Ohio\Core\User;

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

    public function user($id, $team = null)
    {
        $user = $this->users->find($id) ?: $this->abort(404);

        if ($team && !$team->users->contains($id)) {
            $this->abort(404, 'team does not have this user');
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Requests\PaginateTeamUsers $request, $team_id)
    {
        $this->authorize('view', Team::class);

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

        $this->authorize('view', $team);

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

        return response()->json(null, 204);
    }

}
