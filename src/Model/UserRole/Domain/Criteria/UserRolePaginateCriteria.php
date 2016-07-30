<?php
namespace Ohio\Core\Model\UserRole\Domain\Criteria;

use Ohio\Core\Domain\Criteria\BasePaginateCriteria;

/**
 * Class RequestCriteria
 * @package Prettus\Repository\Criteria
 */
class UserRolePaginateCriteria extends BasePaginateCriteria
{

    public $orderBy = 'users_roles.id';

}