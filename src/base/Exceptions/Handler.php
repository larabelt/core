<?php

namespace Ohio\Core\Base\Exceptions;

use Exception;

use Ohio\Core\Base\Http\Exception\ApiException;

use Illuminate\Http\JsonResponse;

class Handler
{
    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public static function render($request, Exception $e)
    {

        if ($e instanceof ApiException) {
            return response()->json($e->getMessage(), $e->getStatusCode());
        }

        if (method_exists($e, 'getResponse')) {
            if ($e->getResponse() instanceof JsonResponse) {
                return response()->json(['message' => $e->getResponse()->getData()], $e->getResponse()->getStatusCode());
            }
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json($e->getMessage(), $e->getStatusCode());
        }

    }
}
