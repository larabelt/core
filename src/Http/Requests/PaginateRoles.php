<?php
namespace Belt\Core\Http\Requests;

use Belt\Core\Http\Requests\PaginateRequest;

class PaginateRoles extends PaginateRequest
{
    public $perPage = 20;

    public $orderBy = 'roles.id';

    public $sortable = [
        'roles.id',
        'roles.name',
    ];

    public $searchable = [
        'roles.name',
    ];

}