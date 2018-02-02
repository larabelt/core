<?php

namespace Belt\Core\Http\Controllers\Api;

use Belt\Core\Index;
use Belt\Core\Http\Requests;
use Belt\Core\Http\Controllers\ApiController;
use Illuminate\Http\Request;

/**
 * Class IndexController
 * @package Belt\Core\Http\Controllers\Auth
 */
class IndexController extends ApiController
{
    /**
     * @var Index
     */
    public $index;

    /**
     * ApiController constructor.
     * @param Index $index
     */
    public function __construct(Index $index)
    {
        $this->index = $index;
    }

    /**
     * Show index results
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request = Requests\PaginateIndex::extend($request);

        $paginator = $this->paginator($this->index->query(), $request);

        return response()->json($paginator->toArray());
    }

}
