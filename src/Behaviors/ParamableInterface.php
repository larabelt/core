<?php namespace Belt\Core\Behaviors;

use Belt\Core\Param;

interface ParamableInterface
{

    public function params();

    public function saveParam($key, $value);

    public function param($key, $default = null);

}