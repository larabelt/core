<?php
namespace Ohio\Core\UserRole;

use Ohio\Core\Base\BaseRepository;

class UserRoleRepository extends BaseRepository
{

    protected $model_class = UserRole::class;

    public function create(array $attributes)
    {

        $input = [
            'user_id' => array_get($attributes, 'user_id'),
            'role_id' => array_get($attributes, 'role_id'),
        ];

        $user_role = $this->findWhere($input)->first();

        if (!$user_role) {
            $user_role = parent::create($input);
        }

        return $user_role;
    }

    public function update(array $attributes, $id)
    {

    }

}