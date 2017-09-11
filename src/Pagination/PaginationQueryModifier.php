<?php

namespace Belt\Core\Pagination;

use Belt\Core\Http\Requests\PaginateRequest;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class BaseQueryModifier
 * @package Belt\Core\Pagination
 */
abstract class PaginationQueryModifier
{
    /**
     * @var \Illuminate\Database\Eloquent\Builder
     */
    public $qb;

    /**
     * @var PaginateRequest
     */
    public $request;

    public function __construct(Builder $qb, PaginateRequest $request)
    {
        $this->qb = $qb;
        $this->request = $request;
    }

    /**
     * Modify query
     *
     * @param Builder $qb
     * @param PaginateRequest $request
     * @return mixed
     */
    abstract public function modify(Builder $qb, PaginateRequest $request);

}