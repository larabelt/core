<?php
namespace Belt\Core\Http\Requests;

class PaginateWorkRequests extends PaginateRequest
{
    public $perPage = 20;

    public $orderBy = 'work_requests.id';

    public $sortBy = 'desc';

    public $sortable = [
        'work_requests.id',
    ];

    public $searchable = [];

}