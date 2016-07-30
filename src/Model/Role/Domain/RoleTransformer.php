<?php
namespace Ohio\Core\Model\Role\Domain;

use Ohio\Core\Domain\BaseTransformer;

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