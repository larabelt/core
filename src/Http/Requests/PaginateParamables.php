<?php
namespace Belt\Core\Http\Requests;

use Belt\Core\Http\Requests\PaginateRequest;
use Illuminate\Database\Eloquent\Builder;

class PaginateParamables extends PaginateRequest
{
    public $perPage = 10;

    public $orderBy = 'params.id';

    public $sortable = [
        'params.id',
        'params.paramable_id',
        'params.paramable_type',
        'params.key',
    ];

    public $searchable = [
        'params.id',
        'params.paramable_id',
        'params.paramable_type',
        'params.key',
        'params.value',
    ];

    public function modifyQuery(Builder $query)
    {
        if ($this->get('paramable_id')) {
            $query->where('paramable_id', $this->get('paramable_id'));
        }

        if ($this->get('paramable_type')) {
            $query->where('paramable_type', $this->get('paramable_type'));
        }

        return $query;
    }

}