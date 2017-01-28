<?php

use Ohio\Core\Helpers\DebugHelper;
use Ohio\Core\Helpers\OhioHelper;

if (!function_exists('ohio')) {
    /**
     * bla
     */
    function ohio()
    {
        return new OhioHelper();
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