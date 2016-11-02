<?php

use Ohio\Core\Base\Http\Exception\ApiNotFoundHttpException;

class ApiNotFoundHttpExceptionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers \Ohio\Core\Base\Http\Exception\ApiException::__construct()
     * @covers \Ohio\Core\Base\Http\Exception\ApiNotFoundHttpException::__construct()
     * @covers \Ohio\Core\Base\Http\Exception\ApiException::getStatusCode()
     * @covers \Ohio\Core\Base\Http\Exception\ApiException::getHeaders()
     */
    public function test()
    {
        $previous = new \Exception('test');

        $exception = new ApiNotFoundHttpException(123, $previous);

        $this->assertEquals($exception->getStatusCode(), 404);
        $this->assertEquals($exception->getHeaders(), null);
        $this->assertEquals($exception->getCode(), 123);
        $this->assertEquals($exception->getPrevious()->getMessage(), 'test');
    }

}