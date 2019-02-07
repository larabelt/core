<?php

use Belt\Core\Helpers\DebugHelper;
use Belt\Core\Helpers\BeltHelper;
use Belt\Core\Helpers\UrlHelper;

if (!function_exists('belt')) {
    /**
     * @codeCoverageIgnore
     */
    function belt()
    {
        //return new BeltHelper();
        return app()->get('belt');
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

if (!function_exists('static_url')) {
    /**
     * @codeCoverageIgnore
     */
    function static_url($path)
    {
        return UrlHelper::staticUrl($path);
    }
}