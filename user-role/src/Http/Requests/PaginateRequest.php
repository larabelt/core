<?php
namespace Ohio\Core\UserRole\Http\Requests;

use Ohio\Core\Base\Http\Requests\BasePaginateRequest;

class PaginateRequest extends BasePaginateRequest
{
    public $perPage = 5;

    public $orderBy = 'user_roles.id';

    public $sortable = [
        'user_roles.id',
        'user_roles.user_id',
        'user_roles.role_id',
    ];

    public $searchable = [
        'user_roles.user_id',
        'user_roles.role_id',
    ];

    public function modifyQuery($query)
    {
        if ($this->get('user_id')) {
            $query->where('user_id', $this->get('user_id'));
        }

        if ($this->get('role_id')) {
            $query->where('role_id', $this->get('role_id'));
        }
    }

}