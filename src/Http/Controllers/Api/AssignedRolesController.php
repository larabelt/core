<?php

namespace Belt\Core\Http\Controllers\Api;

use Bouncer;
use Belt\Core\Role;
use Belt\Core\Behaviors\PermissibleInterface;
use Belt\Core\Http\Controllers\Morphable;
use Belt\Core\Http\Controllers\ApiController;
use Belt\Core\Http\Requests;

/**
 * Class RolesController
 * @package Belt\Core\Http\Controllers\Api
 */
class AssignedRolesController extends ApiController
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
     * @param $subject_type
     * @param $subject_id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Belt\Core\Http\Exceptions\ApiException
     * @throws \Belt\Core\Http\Exceptions\ApiNotFoundHttpException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index($subject_type, $subject_id)
    {
        $permissible = $this->permissible($subject_type, $subject_id);

        $this->authorize(['view', 'create', 'update', 'delete'], $permissible);

        return response()->json($permissible->roles->toArray());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Requests\AttachRole $request
     * @param $subject_type
     * @param $subject_id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Belt\Core\Http\Exceptions\ApiException
     * @throws \Belt\Core\Http\Exceptions\ApiNotFoundHttpException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Requests\AttachRole $request, $subject_type, $subject_id)
    {
        $permissible = $this->permissible($subject_type, $subject_id);

        $this->authorize('attach', Role::class);

        $permissible->roles()->syncWithoutDetaching([$request->get('id')]);

        Bouncer::refreshFor($permissible);

        return response()->json($permissible->roles->toArray(), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param $subject_type
     * @param $subject_id
     * @param $id
     * @return \Illuminate\Http\JsonResponse|void
     * @throws \Belt\Core\Http\Exceptions\ApiException
     * @throws \Belt\Core\Http\Exceptions\ApiNotFoundHttpException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($subject_type, $subject_id, $id)
    {
        /* @var $permissible PermissibleInterface */
        $permissible = $this->permissible($subject_type, $subject_id);

        $this->authorize(['view', 'create', 'update', 'delete'], $permissible);

        $role = $permissible->roles->where('id', $id)->first();

        return $role ? response()->json($role) : $this->abort(404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $subject_type
     * @param $subject_id
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Belt\Core\Http\Exceptions\ApiException
     * @throws \Belt\Core\Http\Exceptions\ApiNotFoundHttpException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($subject_type, $subject_id, $id)
    {
        $permissible = $this->permissible($subject_type, $subject_id);

        $this->authorize('detach', Role::class);

        $permissible->roles()->detach($id);

        Bouncer::refreshFor($permissible);

        return response()->json(null, 204);
    }
}
