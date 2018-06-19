<?php

namespace Belt\Core\Http\Controllers\Api;

use Belt\Core\Behaviors\PermissibleInterface;
use Belt\Core\Http\Controllers\ApiController;
use Belt\Core\Http\Controllers\Morphable;

class AccessController extends ApiController
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
     * Display the specified resource.
     *
     * @param $entity_type
     * @param $entity_id
     * @param array $abilities
     * @param array $arguments
     * @return \Illuminate\Http\JsonResponse
     * @throws \Belt\Core\Http\Exceptions\ApiException
     * @throws \Belt\Core\Http\Exceptions\ApiNotFoundHttpException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($entity_type, $entity_id, $abilities = 'view', $model)
    {
        $permissible = $this->permissible($entity_type, $entity_id);

        $this->authorize(['view', 'create', 'update', 'delete'], $permissible);

        $abilities = explode(',', $abilities);

        //return response()->json(false);
        return response()->json($permissible->can((array) $abilities, $model));
    }

}
