<?php
namespace Ohio\Core;

use Ohio;
use Illuminate\Database\Eloquent\Model;

class Role extends Model implements
    Ohio\Core\Behaviors\SluggableInterface
{

    use Ohio\Core\Behaviors\Sluggable;

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