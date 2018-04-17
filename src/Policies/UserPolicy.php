<?php

namespace Belt\Core\Policies;

use Belt\Core\User;

/**
 * Class UserPolicy
 * @package Belt\Core\Policies
 */
class UserPolicy extends BaseAdminPolicy
{
    /**
     * Determine whether the user can view the object.
     *
     * @param  User $auth
     * @param  mixed $arguments
     * @return mixed
     */
    public function view(User $auth, $arguments = null)
    {
        if ($arguments instanceof User) {
            return $auth->id == $arguments->id;
        }
    }

    /**
     * Determine whether the user can create object.
     *
     * @param  User $auth
     * @param  mixed $arguments
     * @return mixed
     */
    public function register(User $auth, $arguments = null)
    {
        if (config('belt.core.users.allow_public_signup')) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the object.
     *
     * @param  User $auth
     * @param  mixed $arguments
     * @return mixed
     */
    public function update(User $auth, $arguments = null)
    {
        if ($arguments instanceof User) {
            return $auth->id == $arguments->id;
        }
    }

}