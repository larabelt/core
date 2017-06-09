<?php

namespace Belt\Core\Http\Controllers\Api;

use Belt\Core\Param;
use Belt\Core\Http\Controllers\ApiController;
use Belt\Core\Http\Requests;
use Belt\Core\Http\Requests\PaginateRequest;
use Belt\Core\Pagination\GroupLengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class ParamsController extends ApiController
{

    /**
     * @var Param
     */
    public $params;

    /**
     * ParamablesController constructor.
     * @param Param $param
     */
    public function __construct(Param $param)
    {
        $this->params = $param;
    }

    /**
     * @param Builder $qb
     * @param PaginateRequest $request
     * @return GroupLengthAwarePaginator
     */
    public function paginator(Builder $qb, PaginateRequest $request)
    {
        return new GroupLengthAwarePaginator($qb, $request);
    }

    /**
     * Display a listing of the resource.
     *
     * @param $request
     * @return \Illuminate\Http\Response
     */
    public function keys(Request $request)
    {
        $this->authorize('view', Param::class);

        $request = Requests\PaginateRequest::extend($request);

        $request->merge(['group' => 'key']);

        $paginator = $this->paginator($this->params->query(), $request);

        return response()->json($paginator->toArray());
    }

    /**
     * Display a listing of the resource.
     *
     * @param $request
     * @return \Illuminate\Http\Response
     */
    public function values(Request $request)
    {
        $this->authorize('view', Param::class);

        $request = Requests\PaginateRequest::extend($request);

        $request->merge(['group' => 'value']);

        $query = $this->params->query();

        $query->where('value', '!=', '');

        if ($key = $request->get('key')) {
            $query->where('key', $key);
        }

        $paginator = $this->paginator($query, $request);

        return response()->json($paginator->toArray());
    }

}