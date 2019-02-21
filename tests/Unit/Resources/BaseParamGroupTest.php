<?php namespace Tests\Belt\Core\Unit\Resources;

use Belt\Core\Resources\BaseParamGroup;
use Belt\Core\Tests\BeltTestCase;

class BaseParamGroupTest extends BeltTestCase
{
    /**
     * @covers \Belt\Core\Resources\BaseParamGroup::setup
     * @covers \Belt\Core\Resources\BaseParamGroup::setPrefix
     * @covers \Belt\Core\Resources\BaseParamGroup::getPrefix
     * @covers \Belt\Core\Resources\BaseParamGroup::setCollapsible
     * @covers \Belt\Core\Resources\BaseParamGroup::getCollapsible
     * @covers \Belt\Core\Resources\BaseParamGroup::setCollapsed
     * @covers \Belt\Core\Resources\BaseParamGroup::getCollapsed
     * @covers \Belt\Core\Resources\BaseParamGroup::setComponent
     * @covers \Belt\Core\Resources\BaseParamGroup::getComponent
     * @covers \Belt\Core\Resources\BaseParamGroup::toArray
     */
    public function test()
    {
        $resource = StubBaseParamGroupTest::make('foo');

        # set/get prefix
        $resource->setPrefix(false);
        $this->assertEquals(false, $resource->getPrefix());
        $resource->setPrefix('test');
        $this->assertEquals('test', $resource->getPrefix());

        # set/get collapsible
        $resource->setCollapsible('test');
        $this->assertEquals('test', $resource->getCollapsible());

        # set/get collapsed
        $resource->setCollapsed('test');
        $this->assertEquals('test', $resource->getCollapsed());

        # set/get component
        $resource->setComponent('test');
        $this->assertEquals('test', $resource->getComponent());

        # toArray
        $array = $resource->toArray();
        $this->assertEquals('test', array_get($array, 'component'));
    }

}

class StubBaseParamGroupTest extends BaseParamGroup
{

}