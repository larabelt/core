<?php
namespace Ohio\Core\Role\Observers;

use Ohio\Core\Role\Role;

class RoleObserver
{

    /**
     * Listen to the User creating event.
     *
     * @param  Role  $role
     * @return void
     */
    public function creating(Role $role)
    {
        $role->slug = $role->slug ?: str_slug($role->name);
    }

}