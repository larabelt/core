<?php

namespace Belt\Core\Http\Controllers\Api;

use Belt\Core\Behaviors\ParamableInterface;
use Belt\Core\Param;
use Belt\Core\Helpers\MorphHelper;
use Belt\Core\Http\Controllers\ApiController;
use Belt\Core\Http\Requests;
use Belt\Core\Http\Controllers\Morphable;
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
     * @param ParamableInterface $paramable
     * @param Param $param
     */
    public function contains(ParamableInterface $paramable, Param $param)
    {
        if (!$paramable->params->contains($param->id)) {
            $this->abort(404, 'item does not have this param');
        }
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

        $paramable = $this->morphable($paramable_type, $paramable_id);

        $this->authorize('view', $paramable);

        $request->merge([
            'paramable_id' => $paramable->id,
            'paramable_type' => $paramable->getMorphClass()
        ]);

        $paginator = $this->paginator($this->params->query(), $request);

        return response()->json($paginator->toArray());
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
        $paramable = $this->morphable($paramable_type, $paramable_id);

        $this->authorize('update', $paramable);

        $input = $request->all();

        $param = $paramable->saveParam($input['key'], $input['value']);

        $paramable->purgeDuplicateParams($param);

        return response()->json($param, 201);
    }

    /**
     * Update the specified resource in core.
     *
     * @param Requests\UpdateParam $request
     * @param string $paramable_type
     * @param string $paramable_id
     * @param Param $param
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\UpdateParam $request, $paramable_type, $paramable_id, Param $param)
    {
        $paramable = $this->morphable($paramable_type, $paramable_id);

        $this->authorize('update', $paramable);

        $this->contains($paramable, $param);

        $input = $request->all();

        $this->set($param, $input, [
            'value',
        ]);

        $param->save();

        $paramable->purgeDuplicateParams($param);

        return response()->json($param);
    }

    /**
     * Display the specified resource.
     *
     * @param string $paramable_type
     * @param string $paramable_id
     * @param Param $param
     *
     * @return \Illuminate\Http\Response
     */
    public function show($paramable_type, $paramable_id, Param $param)
    {
        $paramable = $this->morphable($paramable_type, $paramable_id);

        $this->authorize('view', $paramable);

        $this->contains($paramable, $param);

        return response()->json($param);
    }

    /**
     * Remove the specified resource from core.
     *
     * @param Param $param
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($paramable_type, $paramable_id, Param $param)
    {
        $paramable = $this->morphable($paramable_type, $paramable_id);

        $this->authorize('update', $paramable);

        $this->contains($paramable, $param);

        $paramable->purgeDuplicateParams($param);

        $param->delete();

        return response()->json(null, 204);
    }
}
