<?php
namespace Belt\Core\Http\Requests;

use Belt\Core\Http\Requests\PaginateRequest;

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