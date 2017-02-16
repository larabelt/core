<?php

namespace Belt\Core\Policies;

use Belt\Core\User;
use Belt\Core\Team;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeamPolicy extends BaseAdminPolicy
{
    /**
     * Determine whether the user can view the object.
     *
     * @param  User $auth
     * @param  Team $team
     * @return mixed
     */
    public function view(User $auth, $team)
    {
        return $team->users->where('id', $auth->id)->first() ? true : false;
    }

    /**
     * Determine whether the user can create object.
     *
     * @param  User $auth
     * @return mixed
     */
    public function create(User $auth)
    {
        return true;
    }

    /**
     * Determine whether the user can update the object.
     *
     * @param  User $auth
     * @param  Team $team
     * @return mixed
     */
    public function update(User $auth, $team)
    {
        return $team->users->where('id', $auth->id)->first() ? true : false;
    }

    /**
     * Determine whether the user can delete the object.
     *
     * @param  User $auth
     * @param  Team $team
     * @return mixed
     */
    public function delete(User $auth, $team)
    {
        return $team->users->where('id', $auth->id)->first() ? true : false;
    }
}
