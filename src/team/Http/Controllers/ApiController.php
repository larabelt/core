<?php

namespace Ohio\Core\Team\Http\Controllers;

use Illuminate\Http\Request;

use Ohio\Core\Team;
use Ohio\Core\Team\Http\Requests;
use Ohio\Core\Base\Http\Controllers\BaseApiController;

class ApiController extends BaseApiController
{

    /**
     * @var Team\Team
     */
    public $team;

    /**
     * ApiController constructor.
     * @param Team\Team $team
     */
    public function __construct(Team\Team $team)
    {
        $this->team = $team;
    }

    public function get($id)
    {
        return $this->team->find($id) ?: $this->abort(404);
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

        $paginator = $this->getPaginator($this->team->query(), $request);

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
        $team = $this->team->create($request->all());

        return response()->json($team);
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
     * Update the specified resource in storage.
     *
     * @param  Requests\UpdateRequest $request
     * @param  string $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\UpdateRequest $request, $id)
    {
        $team = $this->get($id);

        $team->update($request->all());

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
