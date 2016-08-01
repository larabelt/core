<?php
namespace Ohio\Core\Role;

use Ohio\Core\Base\BaseTransformer;

class RoleTransformer extends BaseTransformer
{
    public function transform(Role $role)
    {
        return [
            'id'   => (int) $role->id,
            'name'   => (string) $role->name,
            'slug'   => (string) $role->slug,
        ];
    }
}