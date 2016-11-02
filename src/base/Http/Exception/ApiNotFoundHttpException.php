<?php
namespace Ohio\Core\Base\Http\Exception;

use Exception;

class ApiNotFoundHttpException extends ApiException
{
    protected $statusCode = 404;

    public function __construct($code = 0, Exception $previous = null)
    {
        parent::__construct(null, $code, $previous);
    }

}