<?php

use Ohio\Core\Http\Exceptions\ApiException;
use Illuminate\Support\MessageBag;

class ApiExceptionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers \Ohio\Core\Http\Exceptions\ApiException::__construct()
     * @covers \Ohio\Core\Http\Exceptions\ApiException::getStatusCode()
     * @covers \Ohio\Core\Http\Exceptions\ApiException::setStatusCode()
     * @covers \Ohio\Core\Http\Exceptions\ApiException::getHeaders()
     * @covers \Ohio\Core\Http\Exceptions\ApiException::getMsg()
     * @covers \Ohio\Core\Http\Exceptions\ApiException::setMsg()
     */
    public function test()
    {
        $previous = new \Exception('test');

        $messageBag = new MessageBag(['foo' => 'bar']);

        $exception = new ApiException('msg', 123, $previous);
        $exception->setStatusCode(422);
        $exception->setMsg($messageBag);

        $this->assertEquals($exception->getStatusCode(), 422);
        $this->assertEquals($exception->getHeaders(), null);
        $this->assertEquals($exception->getCode(), 123);
        $this->assertEquals($exception->getMsg(), $messageBag->toArray());
        $this->assertEquals($exception->getPrevious()->getMessage(), 'test');
    }

}