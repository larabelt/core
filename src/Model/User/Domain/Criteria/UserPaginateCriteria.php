<?php
namespace Ohio\Core\Model\User\Domain\Criteria;

use Ohio\Core\Domain\Criteria\BasePaginateCriteria;

/**
 * Class RequestCriteria
 * @package Prettus\Repository\Criteria
 */
class UserPaginateCriteria extends BasePaginateCriteria
{

    public $orderBy = 'users.id';

}