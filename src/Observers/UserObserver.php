<?php

namespace Belt\Core\Observers;

use Belt;
use Belt\Core\User;

class UserObserver
{
    /**
     * Listen to the User created $user.
     *
     * @param  User $user
     * @return void
     */
    public function created(User $user)
    {
        event(new Belt\Core\Events\UserCreated($user));
    }
}