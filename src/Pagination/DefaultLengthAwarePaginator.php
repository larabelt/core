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
            $queryModifier::modify($this->qb, $request);
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

}