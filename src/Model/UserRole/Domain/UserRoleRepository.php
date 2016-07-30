<?php
namespace Ohio\Core\Model\UserRole\Domain;

use Ohio\Core\Domain\BaseRepository;

class UserRoleRepository extends BaseRepository
{

    protected $model_class = UserRole::class;

    public function create(array $attributes)
    {

        $input = [
            'user_id' => array_get($attributes, 'user_id'),
            'role_id' => array_get($attributes, 'role_id'),
        ];

        $user_roles = $this->findWhere($input);

        if (!isset($user_roles['data'][0])) {
            $user_role = parent::create($input);
        } else {
            $user_role['data'] = $user_roles['data'][0];
        }

        return $user_role;
    }

    public function update(array $attributes, $id)
    {

    }

}