<?php

namespace Ohio\Core\Team\Http\Controllers\Api;

use Ohio\Core\Base\Http\Controllers\BaseApiController;
use Ohio\Core\Team\Team;
use Ohio\Core\Team\Http\Requests;
use Ohio\Core\TeamUser\TeamUser;
use Ohio\Core\User\User;

use Illuminate\Http\Request;

class UsersController extends BaseApiController
{

    /**
     * @var Team
     */
    public $team;

    /**
     * @var TeamUser
     */
    public $teamUser;

    /**
     * @var User
     */
    public $user;

    /**
     * ApiController constructor.
     * @param Team $team
     * @param TeamUser $teamUser
     * @param User $user
     */
    public function __construct(Team $team, TeamUser $teamUser, User $user)
    {
        $this->team = $team;
        $this->teamUser = $teamUser;
        $this->user = $user;
    }

    public function team($id)
    {
        return $this->team->find($id) ?: $this->abort(404, 'team not found');
    }

    public function user($userID)
    {
        return $this->user->find($userID) ?: $this->abort(404, 'user not found');
    }

    /**
     * Display a listing of the resource.
     *
     * @param $request
     * @return \Illuminate\Http\Response
     */
    public function index(Requests\UserPaginateRequest $request, $id)
    {
        $request->reCapture()->merge(['team_id' => $id]);

        $paginator = $this->paginator($this->user->query(), $request);

        return response()->json($paginator->toArray());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Requests\UserAttachRequest $request
     * @param  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\UserAttachRequest $request, $id)
    {
        $this->team($id);

        $userID = $request->get('user_id');

        $this->teamUser->firstOrCreate(['team_id' => $id, 'user_id' => $userID]);

        return response()->json(null, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $userID)
    {
        $this->team($id);
        $this->user($userID);

        $this->teamUser->where(['team_id' => $id, 'user_id' => $userID])->delete();

        return response()->json(null, 204);
    }

}
