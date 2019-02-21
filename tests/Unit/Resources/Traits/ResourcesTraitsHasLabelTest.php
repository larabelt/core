<?php namespace Tests\Belt\Core\Unit\Resources;

use Belt\Core\Resources\BaseResource;
use Belt\Core\Resources\Traits\HasLabel;
use Belt\Core\Tests\BeltTestCase;

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