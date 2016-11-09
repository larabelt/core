<?php

use Ohio\Core\Base\Helper\OhioHelper;

if (!function_exists('ohio')) {
    /**
     * bla
     */
    function ohio()
    {
        return new OhioHelper();
    }
}