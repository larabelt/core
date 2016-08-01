<?php
namespace Ohio\Core\UserRole\Criteria;

use Ohio\Core\Base\BaseCriteria\BasePaginateCriteria;

/**
 * Class RequestCriteria
 * @package Prettus\Repository\Criteria
 */
class UserRolePaginateCriteria extends BasePaginateCriteria
{

    public $orderBy = 'users_roles.id';

}