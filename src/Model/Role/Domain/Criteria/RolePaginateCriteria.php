<?php
namespace Ohio\Core\Model\Role\Domain\Criteria;

use Ohio\Core\Domain\Criteria\BasePaginateCriteria;

/**
 * Class RequestCriteria
 * @package Prettus\Repository\Criteria
 */
class RolePaginateCriteria extends BasePaginateCriteria
{

    public $orderBy = 'roles.id';

}