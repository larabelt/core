<?php namespace Tests\Belt\Core\Unit\Resources;

use Belt\Core\Resources\BaseParam;
use Belt\Core\Tests\BeltTestCase;

class BaseParamTest extends BeltTestCase
{
    /**
     * @covers \Belt\Core\Resources\BaseParam::getType
     * @covers \Belt\Core\Resources\BaseParam::setType
     * @covers \Belt\Core\Resources\BaseParam::toArray
     */
    public function test()
    {
        $resource = StubBaseParamTest::make('foo');

        # setType
        $resource->setType('test');

        # getType
        $this->assertEquals('test', $resource->getType());

        # toArray
        $array = $resource->toArray();
        $this->assertEquals('test', array_get($array, 'type'));
    }

}

class StubBaseParamTest extends BaseParam
{

}