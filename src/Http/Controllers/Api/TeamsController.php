<?php

namespace Belt\Core\Http\Controllers\Api;

use Belt;
use Belt\Core\Team;
use Belt\Core\Http\Requests;
use Belt\Core\Http\Controllers\ApiController;
use Illuminate\Http\Request;

/**
 * Class TeamsController
 * @package Belt\Core\Http\Controllers\Api
 */
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

    /**
     * @param $id
     */
    public function get($id)
    {
        return $this->teams->find($id) ?: $this->abort(404);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $this->authorize('index', Team::class);

        $request = Requests\PaginateTeams::extend($request);

        $paginator = $this->paginator($this->teams->query(), $request);

        return response()->json($paginator->toArray());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Requests\StoreTeam $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Requests\StoreTeam $request)
    {
        $this->authorize('create', Team::class);

        $input = $request->all();

        $team = $this->teams->create(['name' => $input['name']]);

        $this->set($team, $input, [
            'default_user_id',
            'is_active',
            'slug',
            'body',
        ]);

        $team->save();

        $this->itemEvent('created', $team);

        return response()->json($team, 201);
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
        $team = $this->get($id);

        $this->authorize('view', $team);

        return response()->json($team);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Requests\UpdateTeam $request
     * @param  string $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Requests\UpdateTeam $request, $id)
    {
        $team = $this->get($id);

        $this->authorize('update', $team);

        $input = $request->all();

        $this->set($team, $input, [
            'default_user_id',
            'is_active',
            'name',
            'slug',
            'body',
        ]);

        $team->save();

        $this->itemEvent('updated', $team);

        return response()->json($team);
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
        $team = $this->get($id);

        $this->authorize('delete', $team);

        $this->itemEvent('deleted', $team);

        $team->delete();

        return response()->json(null, 204);
    }
}
