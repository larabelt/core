<?php namespace Tests\Belt\Core\Unit\Resources;

use Belt\Core\Resources\Subtypes\BaseListItem;
use Belt\Core\Tests\BeltTestCase;

class ResourcesSubtypesBaseListItemTest extends BeltTestCase
{
    /**
     * @covers \Belt\Core\Resources\Subtypes\BaseListItem::toArray
     */
    public function test()
    {
        $resource = StubResourcesSubtypesBaseListItemTest::make('foo');

        # toArray
        $resource->setTile('test');
        $array = $resource->toArray();
        $this->assertEquals('test', array_get($array, 'tile'));
    }

}

class StubResourcesSubtypesBaseListItemTest extends BaseListItem
{

}