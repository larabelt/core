<?php

namespace Belt\Core\Helpers;

/**
 * Class WindowConfigHelper
 * @package Belt\Core\Helpers
 */
class WindowConfigHelper
{
    /**
     * @var array
     */
    public static $config = [
        'activeTeam' => [],
        'adminMode' => [],
        'auth' => [],
        'coords' => [],
    ];

    /**
     * @param $key
     * @param $value
     * @param bool $force
     */
    public static function put($key, $value, $force = false)
    {
        if ($force || !array_get(static::$config, $key)) {
            array_set(static::$config, $key, $value);
        }
    }

    /**
     * @return string
     */
    public static function json()
    {
        return json_encode(static::$config);
    }

}