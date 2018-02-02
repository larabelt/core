<?php

namespace Belt\Core\Policies;

use Belt\Core\User;
use Belt\Core\Team;

/**
 * Class TeamPolicy
 * @package Belt\Core\Policies
 */
class TeamPolicy extends BaseAdminPolicy
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
        return $this->ofTeam($auth, $arguments);
    }

    /**
     * Determine whether the user can create object.
     *
     * @param  User $auth
     * @return mixed
     */
    public function create(User $auth)
    {
        $permission = parent::create($auth);

        if ($permission || config('belt.core.teams.allow_public_signup')) {
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
        return $this->ofTeam($auth, $arguments);
    }

    /**
     * Determine whether the user can delete the object.
     *
     * @param  User $auth
     * @param  mixed $arguments
     * @return mixed
     */
    public function delete(User $auth, $arguments = null)
    {
        return false;
    }
}
