<?php

use Belt\Core\Testing\BeltTestCase;
use Belt\Core\Facades\MorphFacade;

class MorphFacadeTest extends BeltTestCase
{

    /**
     * @covers \Belt\Core\Facades\MorphFacade::getFacadeAccessor
     */
    public function test()
    {
        $facade = new MorphFacadeTestStub();

        $this->assertEquals('morph', $facade->testGetFacadeAccessor());
    }

}

class MorphFacadeTestStub extends MorphFacade
{
    public function testGetFacadeAccessor()
    {
        return static::getFacadeAccessor();
    }
}