<?php namespace Tests\Belt\Core\Unit\Http;

use Belt\Core\Http\Exceptions\ApiException;
use Illuminate\Support\MessageBag;

class ApiExceptionTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @covers \Belt\Core\Http\Exceptions\ApiException::__construct()
     * @covers \Belt\Core\Http\Exceptions\ApiException::getStatusCode()
     * @covers \Belt\Core\Http\Exceptions\ApiException::setStatusCode()
     * @covers \Belt\Core\Http\Exceptions\ApiException::getHeaders()
     * @covers \Belt\Core\Http\Exceptions\ApiException::getMsg()
     * @covers \Belt\Core\Http\Exceptions\ApiException::setMsg()
     */
    public function test()
    {
        $previous = new \Exception('test');

        $messageBag = new MessageBag(['foo' => 'bar']);

        $exception = new ApiException('msg', 123, $previous);
        $exception->setStatusCode(422);
        $exception->setMsg($messageBag);

        $this->assertEquals($exception->getStatusCode(), 422);
        $this->assertEquals($exception->getHeaders(), []);
        $this->assertEquals($exception->getCode(), 123);
        $this->assertEquals($exception->getMsg(), $messageBag->toArray());
        $this->assertEquals($exception->getPrevious()->getMessage(), 'test');
    }

}