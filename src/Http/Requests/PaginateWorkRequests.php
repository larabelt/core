<?php

namespace Belt\Core\Http\Requests;

use Illuminate\Database\Eloquent\Builder;

class PaginateWorkRequests extends PaginateRequest
{
    public $perPage = 20;

    public $orderBy = 'work_requests.id';

    public $sortBy = 'asc';

    public $sortable = [
        'work_requests.id',
        'work_requests.created_at',
        'work_requests.updated_at',
    ];

    public $searchable = [];

    /**
     * @param Builder $query
     * @return Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function modifyQuery(Builder $query)
    {
        if ($this->has('is_open')) {
            $query->where('is_open', $this->get('is_open') ? true : false);
        }

        if ($this->get('workable_id')) {
            $query->where('workable_id', $this->get('workable_id'));
        }

        if ($this->get('workable_type')) {
            $query->where('workable_type', $this->get('workable_type'));
        }

        return $query;
    }

}