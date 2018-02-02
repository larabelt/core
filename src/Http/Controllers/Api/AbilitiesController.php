<?php

namespace Belt\Core\Http\Controllers\Api;

use Belt, Bouncer;
use Belt\Core\Http\Controllers\ApiController;
use Belt\Core\Ability;
use Belt\Core\Http\Requests;
use Illuminate\Http\Request;

class AbilitiesController extends ApiController
{

    /**
     * The repository instance.
     *
     * @var Ability
     */
    public $abilities;

    /**
     * ApiController constructor.
     * @param Ability $ability
     */
    public function __construct(Ability $ability)
    {
        $this->abilities = $ability;
    }

    public function get($id)
    {
        return $this->abilities->find($id) ?: $this->abort(404);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('view', Ability::class);

        $request = Requests\PaginateAbilities::extend($request);

        $paginator = $this->paginator($this->abilities->query(), $request);

        return response()->json($paginator->toArray());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Requests\StoreAbility $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Requests\StoreAbility $request)
    {
        $this->authorize('create', Ability::class);

        $input = $request->all();

        $data = [
            'entity_type' => $input['entity_type'],
            'name' => $input['name'],
        ];

        if ($entity_id = $request->get('entity_id')) {
            $data['entity_id'] = $entity_id;
        }

        $ability = $this->abilities->firstOrCreate($data);

        $this->set($ability, $input, [
            'title',
            'only_owned',
            'scope',
        ]);

        $ability->save();

        return response()->json($ability, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($id)
    {

        $ability = $this->get($id);

        $this->authorize('view', $ability);

        return response()->json($ability);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Requests\UpdateAbility $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Requests\UpdateAbility $request, $id)
    {
        $ability = $this->get($id);

        $this->authorize('update', $ability);

        $input = $request->all();

        $this->set($ability, $input, [
            'title',
            'only_owned',
            'scope',
        ]);

        $ability->save();

        return response()->json($ability);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($id)
    {
        $ability = $this->get($id);

        $this->authorize('delete', $ability);

        $ability->delete();

        return response()->json(null, 204);
    }
}
