<?php

namespace Belt\Core\Policies;

use Belt\Core\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseAdminPolicy
 * @package Belt\Core\Policies
 */
class BaseAdminPolicy
{
    use HandlesAuthorization;

    /**
     * @param $user
     * @param $ability
     * @return bool
     */
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
