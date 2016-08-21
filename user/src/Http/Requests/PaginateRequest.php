<?php
namespace Ohio\Core\User\Http\Requests;

use Ohio\Core\Base\Http\Requests\BasePaginateRequest;

class PaginateRequest extends BasePaginateRequest
{

    public $sortable = [
        'users.id',
        'users.email',
    ];

    public $searchable = [
        'users.email',
    ];

}