<?php
namespace Belt\Core\Http\Requests;

/**
 * Class PaginateUsers
 * @package Belt\Core\Http\Requests
 */
class PaginateUsers extends PaginateRequest
{
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

}