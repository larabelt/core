<?php
namespace Ohio\Core\Model\Role\Domain;

use Ohio\Core\Domain\BaseRepository;

class RoleRepository extends BaseRepository
{

    protected $model_class = Role::class;

    public function create(array $attributes)
    {

        $input = [
            'name' => array_get($attributes, 'name'),
        ];

        $roles = $this->findWhere($input);

        if (!isset($roles['data'][0])) {
            $input['slug'] = str_slug($input['name']);
            $role = parent::create($input);
        } else {
            $role['data'] = $roles['data'][0];
        }

        $attributes = array_merge($role['data'], $attributes);

        return $this->update($attributes, $attributes['id']);
    }

    public function update(array $attributes, $id)
    {

        $role = parent::find($id);

        $attributes = array_merge($role['data'], $attributes);

        if (!$attributes['slug']) {
            $attributes['slug'] = str_slug($attributes['name']);
        }

        return parent::update($attributes, $id);
    }

}