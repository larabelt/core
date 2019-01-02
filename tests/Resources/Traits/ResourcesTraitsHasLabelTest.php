<?php

use Belt\Core\Testing\BeltTestCase;
use Belt\Core\Resources\BaseResource;
use Belt\Core\Resources\Traits\HasLabel;

class ResourcesTraitsHasLabelTest extends BeltTestCase
{
    /**
     * @covers \Belt\Core\Resources\Traits\HasLabel::setLabel
     * @covers \Belt\Core\Resources\Traits\HasLabel::getLabel
     */
    public function test()
    {
        $resource = StubResourcesTraitsHasLabelTest::make('foo');

        # set/get label
        $resource->setLabel('test');
        $this->assertEquals('test', $resource->getLabel());
    }

}

class StubResourcesTraitsHasLabelTest extends BaseResource
{
    use HasLabel;
}