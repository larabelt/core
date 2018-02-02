<?php

namespace Belt\Core;

use Belt;
use Silber\Bouncer\Database\Role as BaseRole;

/**
 * Class Role
 * @package Belt\Core
 */
class Role extends BaseRole
    implements Belt\Core\Behaviors\PermissibleInterface
{

    use Belt\Core\Behaviors\Permissible;

    /**
     * @var string
     */
    protected $morphClass = 'roles';

    /**
     * @var array
     */
    protected $appends = ['super'];

//    /**
//     * Get the class name for polymorphic relations.
//     *
//     * @return string
//     */
//    public function getMoxrphClass()
//    {
//        return $this->morphClass;
//    }

}