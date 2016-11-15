<?php
namespace Ohio\Core\Team\Http\Requests;

use Ohio\Core\Base\Http\Requests\BasePaginateRequest;

class PaginateRequest extends BasePaginateRequest
{
    public $perPage = 5;

    public $orderBy = 'teams.id';

    public $sortable = [
        'teams.id',
        'teams.email',
        'teams.first_name',
        'teams.last_name',
    ];

    public $searchable = [
        'teams.email',
    ];

}