<?php namespace Tests\Belt\Core\Unit\Facades;

use Belt\Core\Facades\MorphFacade;
use Tests\Belt\Core\BeltTestCase;

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