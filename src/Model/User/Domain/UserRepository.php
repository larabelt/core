<?php
namespace Ohio\Core\Model\User\Domain;

use Ohio\Core\Domain\BaseRepository;

class UserRepository extends BaseRepository
{

    protected $model_class = User::class;

    public function create(array $attributes)
    {

        $input = [
            'email' => array_get($attributes, 'email'),
        ];

        $users = $this->findWhere($input);

        if (!isset($users['data'][0])) {
            $user = parent::create($input);
        } else {
            $user['data'] = $users['data'][0];
        }

        $attributes = array_merge($user['data'], $attributes);

        return $this->update($attributes, $attributes['id']);
    }

    public function update(array $attributes, $id)
    {

        $user = parent::find($id);

        $attributes = array_merge($user['data'], $attributes);

        return parent::update($attributes, $id);
    }

}