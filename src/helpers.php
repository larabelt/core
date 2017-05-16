<?php

use Belt\Core\Helpers\DebugHelper;
use Belt\Core\Helpers\BeltHelper;

if (!function_exists('belt')) {
    /**
     * @codeCoverageIgnore
     */
    function belt()
    {
        return new BeltHelper();
    }
}

if (!function_exists('dump_sql')) {
    /**
     * @codeCoverageIgnore
     */
    function dump_sql($qb)
    {
        return DebugHelper::getSql($qb);
    }
}