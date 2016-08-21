<?php
namespace Ohio\Core\User\Criteria;

use Ohio\Core\Base\BaseCriteria\BasePaginateCriteria;

class PaginateCriteria extends BasePaginateCriteria
{

    public $orderBy = 'users.id';

    public $searchable = [
      'users.email'
    ];

}