<?php

namespace Belt\Core\Pagination;

use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class GroupLengthAwarePaginator
 * @package Belt\Core\Pagination
 */
class GroupLengthAwarePaginator extends BaseLengthAwarePaginator
{

    /**
     * Build pagination query.
     *
     * @return GroupLengthAwarePaginator
     */
    public function build()
    {

        $request = $this->request;

        $column = $this->request->get('group');

        $this->qb->select($column)
            ->distinct($column)
            ->orderBy($column);

        if ($needle = $request->needle()) {
            $this->qb->where($column, 'LIKE', "%$needle%");
        }

        $count = $this->qb->count($column);

        $this->qb->take($request->perPage());

        $this->qb->offset($request->offset());

        $paginator = new LengthAwarePaginator(
            $request->items($this->qb),
            $count,
            $request->perPage(),
            $request->page()
        );

        $this->setPaginator($paginator);

        return $this;
    }

}