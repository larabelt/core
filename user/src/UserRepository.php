<?php
namespace Ohio\Core\User;

use Ohio\Core\Base\BaseRepository;

class UserRepository extends BaseRepository
{

    protected $model_class = User::class;

    public function create(array $attributes)
    {
        $input = [
            'email' => array_get($attributes, 'email'),
        ];

        $user = $this->findWhere($input)->first();

        if (!$user) {
            $user = parent::create($input);
        }

        $attributes = array_merge($user->toArray(), $attributes);

        return $this->update($attributes, $attributes['id']);
    }

    public function update(array $attributes, $id)
    {

        $user = parent::find($id);

        $attributes = array_merge($user->toArray(), $attributes);

        return parent::update($attributes, $id);
    }

}