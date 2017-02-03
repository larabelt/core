<?php namespace Ohio\Core\Behaviors;

use Ohio\Core\Param;

interface ParamableInterface
{

    public function params();

    public function saveParam($key, $value);

    public function param($key, $default = null);

}