<?php
namespace Ohio\Core\Role;

use Illuminate\Database\Eloquent\Model;
use Ohio\Core\Base\Behaviors\SluggableTrait;

class Role extends Model
{
    use SluggableTrait;

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

}