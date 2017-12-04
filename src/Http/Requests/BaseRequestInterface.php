<?php

namespace Belt\Core\Http\Requests;

use Illuminate\Http\Request;

interface BaseRequestInterface
{
    /**
     * Create new request instance extending a regular Request instance
     *
     * @param Request $request
     * @return static
     */
    public static function extend(Request $request);

}