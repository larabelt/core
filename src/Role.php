<?php
namespace Belt\Core;

use Belt;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Role
 * @package Belt\Core
 */
class Role extends Model implements
    Belt\Core\Behaviors\SluggableInterface
{

    use Belt\Core\Behaviors\Sluggable;

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

    /**
     * @param $value
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtoupper(trim($value));
    }

}