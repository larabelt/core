<?php

namespace Belt\Core\Pagination;

use Belt\Core\Http\Requests\PaginateRequest;
use Illuminate\Database\Eloquent\Builder;

class IsActiveQueryModifier extends PaginationQueryModifier
{
    /**
     * Modify the query
     *
     * @param  Builder $qb
     * @param  PaginateRequest $request
     * @return void
     */
    public static function modify(Builder $qb, PaginateRequest $request)
    {
        if ($request->query->has('is_active')) {
            $qb->where('is_active', $request->query->get('is_active'));
        }
    }
}