<?php namespace Tests\Belt\Core\Unit\Resources;

use Belt\Core\Resources\BaseResource;
use Belt\Core\Resources\Traits\HasTile;
use Tests\Belt\Core\BeltTestCase;

class ResourcesTraitsHasTileTest extends BeltTestCase
{
    /**
     * @covers \Belt\Core\Resources\Traits\HasTile::setTile
     * @covers \Belt\Core\Resources\Traits\HasTile::getTile
     */
    public function test()
    {
        $resource = StubResourcesTraitsHasTileTest::make('foo');

        # set/get tile
        $resource->setTile('test');
        $this->assertEquals('test', $resource->getTile());
    }

}

class StubResourcesTraitsHasTileTest extends BaseResource
{
    use HasTile;
}