<?php

namespace Ohio\Core\Team\Http\Controllers\Api;

use Ohio\Core\Team\Team;
use Ohio\Core\Team\Http\Requests;
use Ohio\Core\Base\Http\Controllers\ApiController;

class TeamsController extends ApiController
{

    /**
     * @var Team
     */
    public $teams;

    /**
     * ApiController constructor.
     * @param Team $team
     */
    public function __construct(Team $team)
    {
        $this->teams = $team;
    }

    public function get($id)
    {
        return $this->teams->find($id) ?: $this->abort(404);
    }

    /**
     * Display a listing of the resource.
     *
     * @param $request
     * @return \Illuminate\Http\Response
     */
    public function index(Requests\PaginateTeams $request)
    {
        $paginator = $this->paginator($this->teams->query(), $request->reCapture());

        return response()->json($paginator->toArray());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Requests\StoreTeam $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\StoreTeam $request)
    {
        $input = $request->all();

        $team = $this->teams->create(['name' => $input['name']]);

        $this->set($team, $input, [
            'is_active',
            'slug',
            'body',
        ]);

        $team->save();

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
     * @param  Requests\UpdateTeam $request
     * @param  string $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\UpdateTeam $request, $id)
    {
        $team = $this->get($id);

        $input = $request->all();

        $this->set($team, $input, [
            'is_active',
            'name',
            'slug',
            'body',
        ]);

        $team->save();

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
