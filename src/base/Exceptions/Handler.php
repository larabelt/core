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
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $e
     * @return \Illuminate\Http\Response
     */
    public static function render($request, Exception $e)
    {
        if ($e instanceof ApiException || $request->ajax() || $request->wantsJson()) {

            $statusCode = method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 200;

            return response()->json($e->getMessage(), $statusCode);
        }

        if (method_exists($e, 'getResponse')) {
            $response = $e->getResponse();
            if ($response instanceof JsonResponse) {
                return response()->json(['message' => $response->getData()], $response->getStatusCode());
            }
        }

    }
}
