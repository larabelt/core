<?php

namespace Belt\Core\Policies;

use Belt\Core\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Access\HandlesAuthorization;

class BaseAdminPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->hasRole('ADMIN')) {
            return true;
        }
    }

    /**
     * Determine whether the user can view list of objects
     *
     * @param  User $auth
     * @return mixed
     */
    public function index(User $auth)
    {

    }

    /**
     * Determine whether the user can view the object.
     *
     * @param  User $auth
     * @param  Model $object
     * @return mixed
     */
    public function view(User $auth, $object)
    {

    }

    /**
     * Determine whether the user can create object.
     *
     * @param  User $auth
     * @return mixed
     */
    public function create(User $auth)
    {

    }

    /**
     * Determine whether the user can update the object.
     *
     * @param  User $auth
     * @param  Model $object
     * @return mixed
     */
    public function update(User $auth, $object)
    {

    }

    /**
     * Determine whether the user can delete the object.
     *
     * @param  User $auth
     * @param  Model $object
     * @return mixed
     */
    public function delete(User $auth, $object)
    {

    }
}
