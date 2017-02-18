<?php namespace Belt\Core\Behaviors;

/**
 * Interface ParamableInterface
 * @package Belt\Core\Behaviors
 */
interface ParamableInterface
{

    /**
     * @return mixed
     */
    public function params();

    /**
     * @param $key
     * @param $value
     * @return mixed
     */
    public function saveParam($key, $value);

    /**
     * @param $key
     * @param null $default
     * @return mixed
     */
    public function param($key, $default = null);

}