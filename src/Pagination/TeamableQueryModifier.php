<?php

namespace Belt\Core\Pagination;

use Belt\Core\Http\Requests\PaginateRequest;
use Illuminate\Database\Eloquent\Builder;

class TeamableQueryModifier extends PaginationQueryModifier
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
        if ($team_id = $request->query->get('team_id')) {
            $qb->where('team_id', $team_id);
        }
    }

}