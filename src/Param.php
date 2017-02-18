<?php
namespace Belt\Core;

use Belt;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Param
 * @package Belt\Core
 */
class Param extends Model
{
    /**
     * @var string
     */
    protected $morphClass = 'params';

    /**
     * @var string
     */
    protected $table = 'params';

    /**
     * @var array
     */
    protected $fillable = ['key', 'value'];

    /**
     * @param $value
     */
    public function setKeyAttribute($value)
    {
        $this->attributes['key'] = strtolower(trim($value));
    }

    /**
     * @param $value
     */
    public function setValueAttribute($value)
    {
        $this->attributes['value'] = trim($value);
    }

}