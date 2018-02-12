<?php
namespace Belt\Core\Http\Requests;

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

}