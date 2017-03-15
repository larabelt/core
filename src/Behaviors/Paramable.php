<?php namespace Belt\Core\Behaviors;

use Belt\Core\Param;

/**
 * Class Paramable
 * @package Belt\Core\Behaviors
 */
trait Paramable
{

    /**
     * @return mixed
     */
    public function params()
    {
        return $this->morphMany(Param::class, 'paramable');
    }

    /**
     * @param $key
     * @param $value
     * @return mixed
     */
    public function saveParam($key, $value)
    {
        $this->load('params');

        $param = $this->params->where('key', $key)->first();

        if ($param) {
            $param->update(['value' => $value]);
        } else {
            $param = $this->params()->save(new Param(['key' => $key, 'value' => $value]));
        }

        return $param;
    }

    /**
     * @param $key
     * @param null $default
     * @return null
     */
    public function param($key, $default = null)
    {

        $param = $this->params->where('key', $key)->first();

        return $param ? $param->value : $default;
    }

}