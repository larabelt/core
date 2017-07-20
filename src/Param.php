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

    /**
     * @param $value
     * @return mixed
     */
    public function getValueAttribute($value)
    {
        $value = trim($value);

        $value = strtolower($value) == 'true' ? true : $value;
        $value = strtolower($value) == 'false' ? false : $value;

        return $value;
    }

    /**
     * @param $param
     * @param array $options
     * @return Model
     */
    public static function copy($param, $options = [])
    {
        $param = $param instanceof Param ? $param : self::find($param)->first();

        $clone = $param->replicate();
        $clone->paramable_id = array_get($options, 'paramable_id');
        $clone->push();

        return $clone;
    }

}