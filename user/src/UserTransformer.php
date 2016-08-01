<?php
namespace Ohio\Core\User;

use Ohio\Core\Base\BaseTransformer;

class UserTransformer extends BaseTransformer
{
    public function transform(User $user)
    {
        return [
            'id'      => (int) $user->id,
            'is_active'   => (boolean) $user->is_active,
            'is_verified'   => (boolean) $user->is_verified,
            'email'   => (string) $user->email,
            'username'   => (string) $user->username,
            'first_name'   => (string) $user->first_name,
            'last_name'   => (string) $user->last_name,
            'mi'   => (string) $user->mi,
            'created_at'   => $this->carbon($user->created_at),
            'updated_at'   => $this->carbon($user->updated_at),
        ];
    }
}