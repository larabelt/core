<?php
namespace Belt\Core\Http\Requests;

use Belt;

/**
 * Class PaginateUsers
 * @package Belt\Core\Http\Requests
 */
class PaginateUsers extends PaginateRequest
{
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    public $modelClass = Belt\Core\User::class;

    /**
     * @var int
     */
    public $perPage = 5;

    /**
     * @var string
     */
    public $orderBy = 'users.id';

    /**
     * @var array
     */
    public $sortable = [
        'users.id',
        'users.email',
        'users.first_name',
        'users.last_name',
    ];

    /**
     * @var array
     */
    public $searchable = [
        'users.email',
        'users.first_name',
        'users.last_name',
    ];

    /**
     * @var Belt\Core\Pagination\PaginationQueryModifier[]
     */
    public $queryModifiers = [
        Belt\Core\Pagination\InQueryModifier::class,
    ];

}