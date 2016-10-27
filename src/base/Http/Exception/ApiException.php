<?php
namespace Ohio\Core\Base\Http\Exception;

use Exception;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ApiException extends Exception implements HttpExceptionInterface
{
    protected $statusCode;

    protected $headers;

    protected $message = [];

    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function getHeaders()
    {
        return $this->headers;
    }
}