<?php

namespace Belt\Core\Http\Controllers\Api;

use Bouncer;
use Belt\Core\Behaviors\PermissibleInterface;
use Belt\Core\Http\Controllers\ApiController;
use Belt\Core\Http\Requests;
use Belt\Core\Http\Controllers\Morphable;

class PermissionsController extends ApiController
{

    use Morphable;

    /**
     * @param $entity_type
     * @param $entity_id
     * @return PermissibleInterface|\Illuminate\Database\Eloquent\Model|void
     * @throws \Belt\Core\Http\Exceptions\ApiException
     * @throws \Belt\Core\Http\Exceptions\ApiNotFoundHttpException
     */
    private function permissible($entity_type, $entity_id)
    {
        $permissible = $this->morphable($entity_type, $entity_id);

        return $permissible instanceof PermissibleInterface ? $permissible : $this->abort(400);
    }

    /**
     * Display a listing of the resource.
     *
     * @param $entity_type
     * @param $entity_id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Belt\Core\Http\Exceptions\ApiException
     * @throws \Belt\Core\Http\Exceptions\ApiNotFoundHttpException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index($entity_type, $entity_id)
    {
        $permissible = $this->permissible($entity_type, $entity_id);

        $this->authorize('view', $permissible);

        return response()->json($permissible->getAbilities()->toArray());
    }

    /**
     * Store a newly created resource in core.
     *
     * @param Requests\StorePermission $request
     * @param $entity_type
     * @param $entity_id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Belt\Core\Http\Exceptions\ApiException
     * @throws \Belt\Core\Http\Exceptions\ApiNotFoundHttpException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Requests\StorePermission $request, $entity_type, $entity_id)
    {
        $permissible = $this->permissible($entity_type, $entity_id);

        $this->authorize('update', $permissible);

        $ability_id = $request->get('ability_id');

        $permissible->abilities()->syncWithoutDetaching($ability_id);

        $permission = $permissible->abilities->where('id', $ability_id)->first();

        Bouncer::refresh();

        return response()->json($permission, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param $entity_type
     * @param $entity_id
     * @param $ability_id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Belt\Core\Http\Exceptions\ApiException
     * @throws \Belt\Core\Http\Exceptions\ApiNotFoundHttpException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($entity_type, $entity_id, $ability_id)
    {
        $permissible = $this->permissible($entity_type, $entity_id);

        $this->authorize('view', $permissible);

        $permission = $permissible->abilities->where('id', $ability_id)->first();

        return response()->json($permission);
    }

    /**
     * Remove the specified resource from core.
     *
     * @param $entity_type
     * @param $entity_id
     * @param $ability_id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Belt\Core\Http\Exceptions\ApiException
     * @throws \Belt\Core\Http\Exceptions\ApiNotFoundHttpException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($entity_type, $entity_id, $ability_id)
    {
        $permissible = $this->permissible($entity_type, $entity_id);

        $this->authorize('update', $permissible);

        $permissible->abilities()->detach($ability_id);

        Bouncer::refresh();

        return response()->json(null, 204);
    }
}
