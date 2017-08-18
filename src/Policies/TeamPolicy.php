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
     * @param  Team $object
     * @return mixed
     */
    public function view(User $auth, $object)
    {
        return $this->ofTeam($auth, $object);
    }

    /**
     * Determine whether the user can create object.
     *
     * @param  User $auth
     * @return mixed
     */
    public function create(User $auth)
    {
        return false;
    }

    /**
     * Determine whether the user can update the object.
     *
     * @param  User $auth
     * @param  Team $object
     * @return mixed
     */
    public function update(User $auth, $object)
    {
        return $this->ofTeam($auth, $object);
    }

    /**
     * Determine whether the user can delete the object.
     *
     * @param  User $auth
     * @param  Team $object
     * @return mixed
     */
    public function delete(User $auth, $object)
    {
        return false;
    }
}
