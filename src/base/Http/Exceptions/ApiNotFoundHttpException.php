<?php
namespace Ohio\Core\Base\Http\Exceptions;

use Exception;

class ApiNotFoundHttpException extends ApiException
{
    protected $statusCode = 404;

    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}