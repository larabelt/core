<?php
namespace Ohio\Core\UserRole;

use Ohio\Core\Base\BaseTransformer;

class UserRoleTransformer extends BaseTransformer
{
    public function transform(UserRole $user_role)
    {
        return [
            'id'      => (int) $user_role->id,
            'user_id'      => (int) $user_role->user_id,
            'role_id'      => (int) $user_role->role_id,
        ];
    }
}