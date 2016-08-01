<?php
namespace Ohio\Core\User\Criteria;

use Ohio\Core\Base\BaseCriteria\BasePaginateCriteria;

/**
 * Class RequestCriteria
 * @package Prettus\Repository\Criteria
 */
class UserPaginateCriteria extends BasePaginateCriteria
{

    public $orderBy = 'users.id';

}