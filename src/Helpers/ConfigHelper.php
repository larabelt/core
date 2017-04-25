<?php

namespace Belt\Core\Helpers;

/**
 * Class ConfigHelper
 * @package Belt\Core\Helpers
 */
class ConfigHelper
{

    /**
     * @param $prefix
     * @param $name
     * @param 'default' $default
     * @param bool $throwException
     * @return mixed
     * @throws \Exception
     */
    public static function config($prefix, $name, $default = null, $throwException = false)
    {
        $config = config("$prefix.$name");

        if (!$config && $default) {
            $config = config("$prefix.$default");
        }

        if (!$config && $throwException) {
            throw new \Exception("missing config: $prefix.$name");
        }

        return $config;
    }

}