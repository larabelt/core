<?php
namespace Belt\Core\Http\Exceptions;

use Exception;

/**
 * Class ApiNotFoundHttpException
 * @package Belt\Core\Http\Exceptions
 */
class ApiNotFoundHttpException extends ApiException
{
    /**
     * @var int
     */
    protected $statusCode = 404;

    /**
     * ApiNotFoundHttpException constructor.
     * @param string $message
     * @param int $code
     * @param Exception|null $previous
     */
    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}