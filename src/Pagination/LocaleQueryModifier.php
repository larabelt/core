<?php

namespace Belt\Core\Pagination;

use Belt;
use Belt\Core\Http\Requests\PaginateRequest;
use Illuminate\Database\Eloquent\Builder;

class LocaleQueryModifier extends Belt\Core\Pagination\PaginationQueryModifier
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
        if ($locale = $request->get('locale')) {
            $qb->where('locale', $locale);
        }
    }
}