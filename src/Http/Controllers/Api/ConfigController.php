<?php

namespace Belt\Core\Http\Controllers\Api;

use Illuminate\Http\Request;
use Belt\Core\Http\Controllers\ApiController;

/**
 * Class ConfigController
 * @package Belt\Core\Http\Controllers\Api
 */
class ConfigController extends ApiController
{

    /**
     * Display the specified resource.
     *
     * @param  Request $request
     * @param  string $key
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $key = null)
    {

        $path = $request->segment(4);

        /**
         * adding alternate method of sending key b/c certain values
         * can trigger another route instead of this
         */
        $key = $key ?: $request->get('key');

        if ($key) {
            $path .= ".$key";
        }

        $config = config($path);

        return response()->json($config);
    }

}
