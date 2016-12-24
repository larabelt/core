<?php
namespace Ohio\Core\User\Http\Requests;

use Ohio\Core\Base\Http\Requests\PaginateRequest;

class PaginateUsers extends PaginateRequest
{
    public $perPage = 5;

    public $orderBy = 'users.id';

    public $sortable = [
        'users.id',
        'users.email',
        'users.first_name',
        'users.last_name',
    ];

    public $searchable = [
        'users.email',
        'users.first_name',
        'users.last_name',
    ];

}