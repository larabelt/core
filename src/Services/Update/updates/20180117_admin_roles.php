<?php

use Illuminate\Support\Facades\DB;
use Belt\Core\Services\Update\BaseUpdate;
use Belt\Core\Role;

/**
 * Class UpdateService
 * @package Belt\Core\Services
 */
class BeltUpdateAdmin_Roles extends BaseUpdate
{
    public function up()
    {
        $this->info(sprintf('move roles to bouncer'));

        $archivedRoles = DB::table('roles_archived')->get();
        foreach ($archivedRoles as $archivedRole) {
            $role = Role::firstOrCreate(['name' => strtolower($archivedRole->name)]);
            $user_roles = DB::table('user_roles')->where('role_id', $archivedRole->id)->get();
            foreach ($user_roles as $user_role) {
                $user = \Belt\Core\User::find($user_role->user_id);
                $user->assign($role->name);
            }
        }

    }

}