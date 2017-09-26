<?php

namespace Belt\Core\Pagination;

use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class DefaultLengthAwarePaginator
 * @package Belt\Core\Pagination
 */
class DefaultLengthAwarePaginator extends BaseLengthAwarePaginator
{

    /**
     * Build pagination query.
     *
     * @return DefaultLengthAwarePaginator
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

        /**
         * @var $queryModifier PaginationQueryModifier
         */
        foreach ($request->queryModifiers as $queryModifier) {
            //$queryModifier::modify($this->qb, $request);
            $modifier = new $queryModifier($this->qb, $request);
            $modifier->modify($this->qb, $request);
        }

        $request->modifyQuery($this->qb);

        /**
         * Apply join statements via closures
         */
        $refetch = false;
        foreach ($request->joins as $join) {
            $refetch = true;
            $join($this->qb, $request);
        }

        $this->orderBy($request);

        $count = $this->qb->count();

        $perPage = $request->perPage();
        if ($perPage) {
            $this->qb->take($perPage);
            if ($offset = $request->offset()) {
                $this->qb->offset($offset);
            }
        }

        $items = $refetch ? $request->refetch($this->qb) : $request->items($this->qb);

        $paginator = new LengthAwarePaginator(
            $items,
            $count,
            $perPage ?: $count,
            $request->page()
        );

        $this->setPaginator($paginator);

        return $this;
    }

}