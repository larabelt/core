<?php
namespace Ohio\Core\Role\Criteria;

use Ohio\Core\Base\BaseCriteria\BasePaginateCriteria;

/**
 * Class RequestCriteria
 * @package Prettus\Repository\Criteria
 */
class RolePaginateCriteria extends BasePaginateCriteria
{

    public $orderBy = 'roles.id';

}