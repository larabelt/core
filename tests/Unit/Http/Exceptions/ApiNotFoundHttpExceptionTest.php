<?php namespace Tests\Belt\Core\Unit\Http;

use Belt\Core\Http\Exceptions\ApiNotFoundHttpException;

class ApiNotFoundHttpExceptionTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @covers \Belt\Core\Http\Exceptions\ApiNotFoundHttpException::__construct()
     */
    public function test()
    {
        $previous = new \Exception('test');

        $exception = new ApiNotFoundHttpException('msg', 123, $previous);

        $this->assertEquals($exception->getStatusCode(), 404);
        $this->assertEquals($exception->getHeaders(), []);
        $this->assertEquals($exception->getCode(), 123);
        $this->assertEquals($exception->getPrevious()->getMessage(), 'test');
    }

}