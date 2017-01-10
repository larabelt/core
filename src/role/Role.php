<?php
namespace Ohio\Core\Role;

use Illuminate\Database\Eloquent\Model;
use Ohio\Core\Base\Behaviors\SluggableTrait;

class Role extends Model
{
    use SluggableTrait;

    /**
     * @var string
     */
    protected $morphClass = 'roles';

    /**
     * @var string
     */
    protected $table = 'roles';

    /**
     * @var array
     */
    protected $fillable = ['name'];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtoupper(trim($value));
    }

}