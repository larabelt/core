<?php

namespace Belt\Core\Pagination;

use Belt\Core\Http\Requests\PaginateRequest;
use Illuminate\Database\Eloquent\Builder;

class PriorityQueryModifier extends PaginationQueryModifier
{
    /**
     * Modify the query
     *
     * @param  Builder $qb
     * @param  PaginateRequest $request
     * @return void
     */
    public function modify(Builder $qb, PaginateRequest $request)
    {
        if ($request->query->has('priority')) {
            $priority = $request->query->get('priority');
            if (intval($priority) && $priority >= 0) {
                $qb->where($request->morphClass() . '.priority', '>=', $priority);
            }
        }
    }

}