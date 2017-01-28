<?php
namespace Ohio\Core\Http\Exceptions;

use Exception;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Illuminate\Support\MessageBag;

class ApiException extends Exception implements HttpExceptionInterface
{
    protected $statusCode;

    protected $headers;

    protected $msg = [];

    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function setStatusCode($statusCode)
    {
        return $this->statusCode = $statusCode;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function setMsg($msg)
    {
        if ($msg instanceof MessageBag) {
            $msg = $msg->toArray();
        }

        $this->msg = $msg;
    }

    public function getMsg()
    {
        return $this->msg;
    }

}