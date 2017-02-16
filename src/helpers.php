<?php

use Belt\Core\Helpers\DebugHelper;
use Belt\Core\Helpers\BeltHelper;

if (!function_exists('belt')) {
    /**
     * bla
     */
    function belt()
    {
        return new BeltHelper();
    }
}

if (!function_exists('dump_sql')) {
    /**
     * bla
     */
    function dump_sql($qb)
    {
        return DebugHelper::getSql($qb);
    }
}