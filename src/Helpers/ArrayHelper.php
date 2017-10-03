<?php

namespace Belt\Core\Helpers;

/**
 * Class ArrayHelper
 * @package Belt\Core\Helpers
 */
class ArrayHelper
{

    /**
     * Determine if array is associative
     *
     * @param $arr
     * @return bool
     * @credit https://stackoverflow.com/a/173479/1662866
     */
    public static function isAssociative(array $arr)
    {
        if (array() === $arr) {
            return false;
        }

        return array_keys($arr) !== range(0, count($arr) - 1);
    }

    /**
     * Get last item in array
     *
     * @param array $arr
     * @return mixed
     */
    public static function last(array $arr)
    {
        return array_values(array_slice($arr, -1))[0];
    }

}