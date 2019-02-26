<?php namespace Tests\Belt\Core\Unit\Http;

use Belt\Core\Http\Middleware\EncryptCookies;
use Tests\Belt\Core\BeltTestCase;
use Illuminate\Encryption\Encrypter;
use Mockery as m;

class EncryptCookiesTest extends BeltTestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Http\Middleware\EncryptCookies::__construct
     * @covers \Belt\Core\Http\Middleware\EncryptCookies::except
     */
    public function test()
    {
        EncryptCookies::except('foo');

        $encrypter = new Encrypter(str_random(16));

        $service = new EncryptCookiesTestStub($encrypter);

        $this->assertTrue(in_array('foo', $service->getExcept()));
    }

}

class EncryptCookiesTestStub extends EncryptCookies
{
    public function getExcept()
    {
        return $this->except;
    }
}