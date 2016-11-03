<?php
namespace Ohio\Core\Role;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    protected $morphClass = 'core/role';

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