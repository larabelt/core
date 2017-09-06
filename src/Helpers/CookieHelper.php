<?php

namespace Belt\Core\Helpers;

use Belt, Cookie;

/**
 * Class CookieHelper
 * @package Belt\Core\Helpers
 */
class CookieHelper
{

    /**
     * @param $group
     * @param $path
     * @param null $default
     * @return mixed|null|string
     */
    public static function getJson($group, $path, $default = null)
    {

        $value = Cookie::get($group);

        if (!$value) {
            return $default;
        }

        if (!Belt\Core\Helpers\StrHelper::isJson($value)) {
            return $value;
        }

        $values = json_decode($value, true);

        return array_get($values, $path, $default);
    }

}