<?php

use Belt\Core\Testing\BeltTestCase;
use Belt\Core\Resources\BaseResource;
use Belt\Core\Resources\Traits\HasForceCompile;

class ResourcesTraitsHasForceCompileTest extends BeltTestCase
{
    /**
     * @covers \Belt\Core\Resources\Traits\HasForceCompile::setForceCompile
     * @covers \Belt\Core\Resources\Traits\HasForceCompile::isForceCompile
     */
    public function test()
    {
        $resource = StubResourcesTraitsHasForceCompileTest::make('foo');

        # set/is forceCompile
        $resource->setForceCompile('test');
        $this->assertEquals('test', $resource->isForceCompile());
    }

}

class StubResourcesTraitsHasForceCompileTest extends BaseResource
{
    use HasForceCompile;
}