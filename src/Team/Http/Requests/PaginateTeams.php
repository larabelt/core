<?php
namespace Ohio\Core\Team\Http\Requests;

use Ohio\Core\Base\Http\Requests\PaginateRequest;

class PaginateTeams extends PaginateRequest
{
    public $perPage = 5;

    public $orderBy = 'teams.id';

    public $sortable = [
        'teams.id',
        'teams.name',
    ];

    public $searchable = [
        'teams.name',
    ];

}