<?php
namespace Ohio\Core\Role\Http\Requests;

use Ohio\Core\Base\Http\Requests\BasePaginateRequest;

class PaginateRequest extends BasePaginateRequest
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