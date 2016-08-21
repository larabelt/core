<?php
namespace Ohio\Core\Role;

use Ohio\Core\Base\BaseModel;
use Illuminate\Contracts\Auth\Authenticatable;

class Role extends BaseModel
{

    protected $morphClass = 'Role';

    protected $table = 'roles';

    protected $guarded = ['id'];

    public function __toString()
    {
        return (string) $this->name;
    }
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtoupper(trim($value));
    }
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = str_slug(trim($value));
    }

}