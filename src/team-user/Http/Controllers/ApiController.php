<?php

namespace Ohio\Core\TeamUser\Http\Controllers;

use Illuminate\Http\Request;

use Ohio\Core\TeamUser;
use Ohio\Core\TeamUser\Http\Requests;
use Ohio\Core\Base\Http\Controllers\BaseApiController;

class ApiController extends BaseApiController
{

    /**
     * @var TeamUser\TeamUser
     */
    public $teamUser;

    /**
     * ApiController constructor.
     * @param TeamUser\TeamUser $teamUser
     */
    public function __construct(TeamUser\TeamUser $teamUser)
    {
        $this->teamUser = $teamUser;
    }

    public function get($id)
    {
        return $this->teamUser->find($id) ?: $this->abort(404);
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

        $qb = $this->teamUser->query();
        $qb->with('user');

        $paginator = $this->getPaginator($qb, $request);

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

        $teamUser = $this->teamUser->create($request->all());

        return response()->json($teamUser);
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
        $team = $this->get($id);

        return response()->json($team);
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
        $team = $this->get($id);

        $team->delete();

        return response()->json(null, 204);
    }
}
