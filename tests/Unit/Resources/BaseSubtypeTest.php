<?php namespace Tests\Belt\Core\Unit\Resources;

use Belt\Core\Resources\BaseSubtype;
use Tests\Belt\Core\BeltTestCase;

class BaseSubtypeTest extends BeltTestCase
{
    /**
     * @covers \Belt\Core\Resources\BaseSubtype::setup
     * @covers \Belt\Core\Resources\BaseSubtype::setBuilder
     * @covers \Belt\Core\Resources\BaseSubtype::getBuilder
     * @covers \Belt\Core\Resources\BaseSubtype::setPreview
     * @covers \Belt\Core\Resources\BaseSubtype::getPreview
     * @covers \Belt\Core\Resources\BaseSubtype::setExtends
     * @covers \Belt\Core\Resources\BaseSubtype::getExtends
     * @covers \Belt\Core\Resources\BaseSubtype::setPath
     * @covers \Belt\Core\Resources\BaseSubtype::getPath
     * @covers \Belt\Core\Resources\BaseSubtype::toArray
     */
    public function test()
    {
        $resource = StubBaseSubtypeTest::make('foo');

        # set/get builder
        $resource->setBuilder('test');
        $this->assertEquals('test', $resource->getBuilder());

        # set/get preview
        $resource->setPreview('test');
        $this->assertEquals('test', $resource->getPreview());

        # set/get extends
        $resource->setExtends('test');
        $this->assertEquals('test', $resource->getExtends());

        # set/get path
        $resource->setPath('test');
        $this->assertEquals('test', $resource->getPath());

        # toArray
        $array = $resource->toArray();
        $this->assertEquals('test', array_get($array, 'builder'));
    }

}

class StubBaseSubtypeTest extends BaseSubtype
{

}