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
        if ($arguments instanceof Team) {
            $this->teamService()->user = $auth;
            if ($this->teamService()->isAuthorized($arguments->id)) {
                return true;
            }
        }
    }

    /**
     * Determine whether the user can create object.
     *
     * @param  User $auth
     * @param  mixed $arguments
     * @return mixed
     */
    public function create(User $auth, $arguments = null)
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
        if ($arguments instanceof Team) {
            $this->teamService()->user = $auth;
            if ($this->teamService()->isAuthorized($arguments->id)) {
                return true;
            }
        }
    }

}
