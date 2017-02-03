<?php

namespace Ohio\Core\Http\Controllers\Api;

use Ohio\Core\Behaviors\ParamableInterface;
use Ohio\Core\Param;
use Ohio\Core\Helpers\MorphHelper;
use Ohio\Core\Http\Controllers\ApiController;
use Ohio\Core\Http\Requests;

class ParamsController extends ApiController
{

    /**
     * @var Param
     */
    public $params;

    /**
     * @var MorphHelper
     */
    public $morphHelper;

    public function __construct(Param $param, MorphHelper $morphHelper)
    {
        $this->params = $param;
        $this->morphHelper = $morphHelper;
    }

    public function param($id, ParamableInterface $paramable = null)
    {
        $qb = $this->params->query();

        if ($paramable) {
            $qb->where('paramable_type', $paramable->getMorphClass());
            $qb->where('paramable_id', $paramable->id);
        }

        $param = $qb->where('params.id', $id)->first();

        return $param ?: $this->abort(404);
    }

    /**
     * @param $paramable_type
     * @param $paramable_id
     * @return ParamableInterface
     */
    public function paramable($paramable_type, $paramable_id)
    {
        $paramable = $this->morphHelper->morph($paramable_type, $paramable_id);

        return $paramable ?: $this->abort(404);
    }

    /**
     * Display a listing of the resource.
     *
     * @param $request
     * @return \Illuminate\Http\Response
     */
    public function index(Requests\PaginateParams $request, $paramable_type, $paramable_id)
    {
        $request->reCapture();

        $owner = $this->paramable($paramable_type, $paramable_id);

        $this->authorize('view', $owner);

        $request->merge([
            'paramable_id' => $owner->id,
            'paramable_type' => $owner->getMorphClass()
        ]);

        $paginator = $this->paginator($this->params->query(), $request);

        return response()->json($paginator->toArray());
    }

    /**
     * Store a newly created resource in core.
     *
     * @param  Requests\StoreParam $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\StoreParam $request, $paramable_type, $paramable_id)
    {
        $owner = $this->paramable($paramable_type, $paramable_id);

        $this->authorize('update', $owner);

        $input = $request->all();

        $param = $owner->saveParam($input['key'], $input['value']);

        return response()->json($param, 201);
    }

    /**
     * Update the specified resource in core.
     *
     * @param  Requests\UpdateParam $request
     * @param  string $paramable_type
     * @param  string $paramable_id
     * @param  string $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\UpdateParam $request, $paramable_type, $paramable_id, $id)
    {
        $owner = $this->paramable($paramable_type, $paramable_id);

        $this->authorize('update', $owner);

        $param = $this->param($id, $owner);

        $input = $request->all();

        $this->set($param, $input, [
            'value',
        ]);

        return response()->json($param);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($paramable_type, $paramable_id, $id)
    {
        $owner = $this->paramable($paramable_type, $paramable_id);

        $this->authorize('view', $owner);

        $param = $this->param($id, $owner);

        return response()->json($param);
    }

    /**
     * Remove the specified resource from core.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($paramable_type, $paramable_id, $id)
    {
        $owner = $this->paramable($paramable_type, $paramable_id);

        $this->authorize('update', $owner);

        $param = $this->param($id, $owner);

        $param->delete();

        return response()->json(null, 204);
    }
}
