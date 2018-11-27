<?php

namespace Belt\Core\Http\Controllers\Api;

use Belt\Core\Behaviors\ParamableInterface;
use Belt\Core\Param;
use Belt\Core\Helpers\MorphHelper;
use Belt\Core\Http\Controllers\ApiController;
use Belt\Core\Http\Requests;
use Belt\Core\Http\Controllers\Behaviors\Morphable;
use Illuminate\Http\Request;

class ParamablesController extends ApiController
{

    use Morphable;

    /**
     * @var Param
     */
    public $params;

    /**
     * ParamablesController constructor.
     * @param Param $param
     * @param MorphHelper $morphHelper
     */
    public function __construct(Param $param, MorphHelper $morphHelper)
    {
        $this->params = $param;
    }

    /**
     * @param $paramable_type
     * @param $paramable_id
     * @param $id
     */
    public function param($paramable_type, $paramable_id, $id)
    {
        $qb = $this->params->query();
        $qb->where('paramable_type', $paramable_type);
        $qb->where('paramable_id', $paramable_id);

        if (is_numeric($id)) {
            $qb->where('id', $id);
        } else {
            $qb->where('key', $id);
        }

        return $qb->first() ?: $this->abort(404);
    }

    /**
     * Display a listing of the resource.
     *
     * @param $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $paramable_type, $paramable_id)
    {
        $request = Requests\PaginateParamables::extend($request);

        $paramable = $this->morph($paramable_type, $paramable_id);

        $this->authorize(['view', 'create', 'update', 'delete'], $paramable);

        $request->merge([
            'paramable_id' => $paramable->id,
            'paramable_type' => $paramable->getMorphClass()
        ]);

        $paginator = $this->paginator($this->params->query(), $request);

        $response = $paginator->toArray();

        $response['config']['params'] = $paramable->getParamConfig();
        $response['config']['groups'] = $paramable->getParamGroupsConfig();

        return response()->json($response);
    }

    /**
     * Store a newly created resource in core.
     *
     * @param Requests\StoreParam $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\StoreParam $request, $paramable_type, $paramable_id)
    {
        /**
         * @var $paramable ParamableInterface
         */
        $owner = $this->morph($paramable_type, $paramable_id);

        $this->authorize('update', $owner->owner ?: $owner);

        $input = $request->all();

        $param = $owner->saveParam($input['key'], $input['value']);

        $owner->purgeDuplicateParams($param);

        $this->itemEvent('params.created', $owner);

        return response()->json($param, 201);
    }

    /**
     * Update the specified resource in core.
     *
     * @param Requests\UpdateParam $request
     * @param string $paramable_type
     * @param string $paramable_id
     * @param mixed $id
     *
     * @return \Illuminate\Http\Response
     */
    //public function update(Requests\UpdateParam $request, $paramable_type, $paramable_id, Param $param)
    public function update(Requests\UpdateParam $request, $paramable_type, $paramable_id, $id)
    {
        $owner = $this->morph($paramable_type, $paramable_id);

        $this->authorize('update', $owner->owner ?: $owner);

        //$this->contains($paramable, $param);
        $param = $this->param($paramable_type, $paramable_id, $id);

        $input = $request->all();

        $this->set($param, $input, [
            'value',
        ]);

        $param->save();

        $owner->purgeDuplicateParams($param);

        $this->itemEvent('params.updated', $owner);

        unset($param->paramable);

        return response()->json($param);
    }

    /**
     * Display the specified resource.
     *
     * @param string $paramable_type
     * @param string $paramable_id
     * @param mixed $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($paramable_type, $paramable_id, $id)
    {
        $paramable = $this->morph($paramable_type, $paramable_id);

        $this->authorize(['view', 'create', 'update', 'delete'], $paramable);

        //$this->contains($paramable, $param);
        $param = $this->param($paramable_type, $paramable_id, $id);

        unset($param->paramable);

        return response()->json($param);
    }

    /**
     * Remove the specified resource from core.
     *
     * @param mixed $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($paramable_type, $paramable_id, $id)
    {
        $owner = $this->morph($paramable_type, $paramable_id);

        $this->authorize('update', $owner);

        //$this->contains($paramable, $param);
        $param = $this->param($paramable_type, $paramable_id, $id);

        $owner->purgeDuplicateParams($param);

        $param->delete();

        $this->itemEvent('params.deleted', $owner);

        return response()->json(null, 204);
    }
}
