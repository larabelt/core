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
    public function modify(Builder $qb, PaginateRequest $request)
    {
        if ($request->query->has('is_active')) {
            $qb->where('is_active', $request->query->get('is_active'));
        }
    }

    /**
     * Modify the query
     *
     * @param  array $query
     * @param  PaginateRequest $request
     * @return $query
     */
    public static function elastic(array $query, PaginateRequest $request)
    {

        if ($request->query->has('is_active')) {
            $query['bool']['must'][]['terms'] = [
                'is_active' => [$request->query->get('is_active') ? true : false],
            ];
        }

        return $query;
    }
}