<?php
namespace Belt\Core\Http\Requests;

use Belt;
use Belt\Core\Http\Requests\PaginateRequest;

class PaginateTeams extends PaginateRequest
{
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    public $modelClass = Belt\Core\Team::class;

    public $perPage = 20;

    public $orderBy = 'teams.id';

    public $sortable = [
        'teams.id',
        'teams.name',
        'teams.created_at',
        'teams.updated_at',
    ];

    public $searchable = [
        'teams.name',
    ];

    /**
     * @var Belt\Core\Pagination\PaginationQueryModifier[]
     */
    public $queryModifiers = [
        Belt\Core\Pagination\InQueryModifier::class,
    ];

}