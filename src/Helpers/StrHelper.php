<?php
namespace Belt\Core\Helpers;

/**
 * Class StrHelper
 * @package Belt\Core\Helpers
 */
class StrHelper
{

    /**
     * @param $s
     * @return bool
     */
    public static function isJson($s)
    {
        json_decode($s);

        return (json_last_error() == JSON_ERROR_NONE);
    }

}