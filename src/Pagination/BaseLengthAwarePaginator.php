<?php

namespace Belt\Core\Pagination;

use Belt\Core\Http\Requests\PaginateRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class BaseLengthAwarePaginator
 * @package Belt\Core\Pagination
 */
abstract class BaseLengthAwarePaginator
{
    /**
     * @var PaginateRequest
     */
    public $request;

    /**
     * @var \Illuminate\Database\Eloquent\Builder
     */
    public $qb;

    /**
     * @var LengthAwarePaginator
     */
    public $paginator;

    /**
     * DefaultLengthAwarePaginator constructor.
     * @param Builder $qb
     * @param PaginateRequest $request
     */
    public function __construct(Builder $qb = null, PaginateRequest $request)
    {
        $this->qb = $qb;

        $this->request = $request;
    }

    /**
     *
     */
    public function build()
    {

    }

    /**
     * Set paginator
     *
     * @param LengthAwarePaginator $paginator
     * @return $this
     */
    public function setPaginator(LengthAwarePaginator $paginator)
    {
        $paginator->request = $this->request;

        $paginator->appends($this->request->query());

        $this->paginator = $paginator;

        return $this;
    }

    /**
     * @param $request
     */
    public function orderBy($request)
    {
        $orderBy = $request->orderBy();
        if ($orderBy) {
            foreach (explode(',', $orderBy) as $orderBy) {
                $prefix = substr($orderBy, 0, 1);
                $sortBy = $prefix == '-' ? 'desc' : $request->sortBy();
                $this->qb->orderBy(ltrim($orderBy, '-'), $sortBy);
            }
        }
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $array = $this->paginator->toArray();

        $array['meta']['request'] = $this->request->query();

        return $array;
    }

}