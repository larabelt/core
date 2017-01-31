<?php

namespace Ohio\Core\Policies;

use Ohio\Core\User;

class UserPolicy extends BaseAdminPolicy
{
    /**
     * Determine whether the user can view the object.
     *
     * @param  User $auth
     * @param  User $user
     * @return mixed
     */
    public function view(User $auth, $user)
    {
        return $auth->id == $user->id;
    }

    /**
     * Determine whether the user can update the object.
     *
     * @param  User $auth
     * @param  User $user
     * @return mixed
     */
    public function update(User $auth, $user)
    {
        return $auth->id == $user->id;
    }

}