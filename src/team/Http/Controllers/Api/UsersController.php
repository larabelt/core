<?php

namespace Ohio\Core\Team\Http\Controllers\Api;

use DB;
use Ohio\Core\Team;
use Ohio\Core\User;
use Ohio\Core\Team\Http\Requests;
use Ohio\Core\Base\Http\Controllers\BaseApiController;

use Illuminate\Http\Request;

class UsersController extends BaseApiController
{

    /**
     * @var Team\Team
     */
    public $team;

    /**
     * @var User\User
     */
    public $user;

    /**
     * ApiController constructor.
     * @param User\User $user
     */
    public function __construct(Team\Team $team, User\User $user)
    {
        $this->team = $team;
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
    public function index(Request $request, $id)
    {
        $request->merge(['team_id' => $id]);

        $request = $this->getPaginateRequest(Requests\UserPaginateRequest::class, $request->query());

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
    public function store(Requests\UserAttachRequest $request, $id)
    {
        $this->team($id);

        $userID = $request->get('user_id');

        DB::table('team_users')->insert(['team_id' => $id, 'user_id' => $userID]);

        return response()->json(1);
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

        DB::table('team_users')->where(['team_id' => $id, 'user_id' => $userID])->delete();

        return response()->json(null, 204);
    }

}
