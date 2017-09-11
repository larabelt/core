<?php

namespace Belt\Core\Pagination;

use Belt\Core\Http\Requests\PaginateRequest;
use Illuminate\Database\Eloquent\Builder;

class InQueryModifier extends PaginationQueryModifier
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
        if ($in = $request->query->get('in')) {
            $qb->whereIn($request->fullKey(), explode(',', $in));
        }

        if ($not_in = $request->query->get('not_in')) {
            $qb->whereNotIn($request->fullKey(), explode(',', $not_in));
        }
    }

}