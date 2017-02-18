<?php

namespace Belt\Core\Policies;

use Belt\Core\User;

/**
 * Class RolePolicy
 * @package Belt\Core\Policies
 */
class RolePolicy extends BaseAdminPolicy
{

    /**
     * Determine whether the user can view list of objects
     *
     * @param  User $auth
     * @return mixed
     */
    public function attach(User $auth)
    {

    }

    /**
     * Determine whether the user can view list of objects
     *
     * @param  User $auth
     * @return mixed
     */
    public function detach(User $auth)
    {

    }
}