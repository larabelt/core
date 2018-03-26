<?php
namespace Belt\Core\Http\Requests;

use Belt;
use Belt\Core\Http\Requests\PaginateRequest;

class PaginateRoles extends PaginateRequest
{
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    public $modelClass = Belt\Core\Role::class;

    public $perPage = 20;

    public $orderBy = 'roles.id';

    public $sortable = [
        'roles.id',
        'roles.name',
        'roles.created_at',
        'roles.updated_at',
    ];

    public $searchable = [
        'roles.name',
    ];

    /**
     * @var Belt\Core\Pagination\PaginationQueryModifier[]
     */
    public $queryModifiers = [
        Belt\Core\Pagination\InQueryModifier::class,
    ];

}