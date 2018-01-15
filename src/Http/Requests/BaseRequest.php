<?php

namespace Belt\Core\Http\Requests;

use Illuminate\Http\Request;

trait BaseRequest
{
    /**
     * Create new PageRequest instance extending a regular Request instance
     *
     * @param Request $request
     * @return static
     */
    public static function extend(Request $request)
    {
        $new = new static();

        $new->initialize(
            $request->query->all(),
            $request->request->all(),
            $request->attributes->all(),
            $request->cookies->all(),
            $request->files->all(),
            $request->server->all(),
            $request->getContent()
        );

        return $new;
    }

}