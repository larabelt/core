<?php
namespace Ohio\Core\Role;

use Ohio\Core\Base\BaseRepository;

class RoleRepository extends BaseRepository
{

    protected $model_class = Role::class;

    public function create(array $attributes)
    {

        $input = [
            'name' => array_get($attributes, 'name'),
        ];

        $role = $this->findWhere($input)->first();

        if (!$role) {
            $input['slug'] = str_slug($input['name']);
            $role = parent::create($input);
        }

        $attributes = array_merge($role->toArray(), $attributes);

        return $this->update($attributes, $attributes['id']);
    }

    public function update(array $attributes, $id)
    {

        $role = parent::find($id);

        $attributes = array_merge($role->toArray(), $attributes);

        if (!$attributes['slug']) {
            $attributes['slug'] = str_slug($attributes['name']);
        }

        return parent::update($attributes, $id);
    }

}