<?php
namespace Ohio\Core\Helpers;

class StrHelper
{

    public static function isJson($s)
    {
        json_decode($s);

        return (json_last_error() == JSON_ERROR_NONE);
    }

}