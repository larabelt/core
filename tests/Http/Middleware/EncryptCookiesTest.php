<?php

use Mockery as m;

use Belt\Core\Testing\BeltTestCase;
use Belt\Core\Http\Middleware\EncryptCookies;
use Illuminate\Encryption\Encrypter;

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