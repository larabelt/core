<?php
namespace Belt\Core\Http\Requests;

use Belt;
use Belt\Core\Http\Requests\PaginateRoles as PaginateRequest;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class PaginateUserRoles
 * @package Belt\Core\Http\Requests
 */
class PaginateUserRoles extends PaginateRequest
{

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    public $modelClass = Belt\Core\Role::class;

    /**
     * @var int
     */
    public $perPage = 5;

    /**
     * @var Belt\Core\Pagination\PaginationQueryModifier[]
     */
    public $queryModifiers = [];

    /**
     * @inheritdoc
     */
    public function modifyQuery(Builder $query)
    {
        # show roles associated with user
        if (!$this->get('not')) {
            $this->joins['user_roles'] = function ($qb) {
                $qb->join('user_roles', 'user_roles.role_id', '=', 'roles.id');
            };
            $query->where('user_roles.user_id', $this->get('user_id'));
        }

        # show roles not associated with user
        if ($this->get('not')) {
            $this->joins['user_roles'] = function ($qb) {
                $qb->leftJoin('user_roles', function ($sub) {
                    $sub->on('user_roles.role_id', '=', 'roles.id');
                    $sub->where('user_roles.user_id', $this->get('user_id'));
                });
            };
            $query->whereNull('user_roles.id');
        }

        return $query;
    }

}