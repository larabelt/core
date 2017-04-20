<?php

namespace Belt\Core\Pagination;

use Belt\Core\Http\Requests\PaginateRequest;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class BaseQueryModifier
 * @package Belt\Core\Pagination
 */
abstract class PaginationQueryModifier
{
    abstract public static function modify(Builder $qb, PaginateRequest $request);
}