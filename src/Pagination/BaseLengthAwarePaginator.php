<?php

namespace Belt\Core\Pagination;

use Belt\Core\Http\Requests\PaginateRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class BaseLengthAwarePaginator
 * @package Belt\Core\Pagination
 */
class BaseLengthAwarePaginator
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
     * BaseLengthAwarePaginator constructor.
     * @param Builder $qb
     * @param PaginateRequest $request
     */
    public function __construct(Builder $qb, PaginateRequest $request)
    {
        $this->qb = $qb;

        $this->request = $request;

        $this->build();
    }

    /**
     *
     */
    public function build()
    {

        $request = $this->request;

        $needle = $request->needle();
        if ($needle && $request->searchable) {
            $this->qb->where(function ($subQB) use ($needle, $request) {
                foreach ($request->searchable as $column) {
                    $subQB->orWhere($column, 'LIKE', "%$needle%");
                }
            });
        }

        $request->modifyQuery($this->qb);

        $this->orderBy($request);

        $count = $this->qb->count();

        $this->qb->take($request->perPage());
        $this->qb->offset($request->offset());

        $paginator = new LengthAwarePaginator(
            $request->items($this->qb),
            $count,
            $request->perPage(),
            $request->page()
        );

        $paginator->request = $request;

        $paginator->appends($request->query());

        $this->paginator = $paginator;
    }

    public function orderBy($request)
    {
        $orderBy = $request->orderBy();
        if ($orderBy) {
            foreach (explode(',', $orderBy) as $orderBy) {
                $prefix = substr($orderBy, 0, 1);
                $sortBy = $prefix == '-' ? 'desc' : $request->sortBy();
                //echo $orderBy . "\n";
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