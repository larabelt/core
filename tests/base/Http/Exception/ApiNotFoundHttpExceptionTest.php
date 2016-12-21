<?php

use Ohio\Core\Base\Http\Exceptions\ApiNotFoundHttpException;

class ApiNotFoundHttpExceptionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers \Ohio\Core\Base\Http\Exceptions\ApiException::__construct()
     * @covers \Ohio\Core\Base\Http\Exceptions\ApiNotFoundHttpException::__construct()
     * @covers \Ohio\Core\Base\Http\Exceptions\ApiException::getStatusCode()
     * @covers \Ohio\Core\Base\Http\Exceptions\ApiException::getHeaders()
     */
    public function test()
    {
        $previous = new \Exception('test');

        $exception = new ApiNotFoundHttpException('msg', 123, $previous);

        $this->assertEquals($exception->getStatusCode(), 404);
        $this->assertEquals($exception->getHeaders(), null);
        $this->assertEquals($exception->getCode(), 123);
        $this->assertEquals($exception->getPrevious()->getMessage(), 'test');
    }

}