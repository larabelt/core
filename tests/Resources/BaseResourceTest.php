<?php

use Belt\Core\Testing\BeltTestCase;
use Belt\Core\Resources\BaseResource;

class BaseResourceTest extends BeltTestCase
{
    /**
     * @covers \Belt\Core\Resources\BaseResource::__construct
     * @covers \Belt\Core\Resources\BaseResource::make
     * @covers \Belt\Core\Resources\BaseResource::setup
     * @covers \Belt\Core\Resources\BaseResource::getKey
     * @covers \Belt\Core\Resources\BaseResource::setKey
     * @covers \Belt\Core\Resources\BaseResource::toArray
     */
    public function test()
    {
        # make
        # construct
        # setKey
        $resource = StubBaseResourceTest::make('foo');

        # getKey
        $this->assertEquals('foo', $resource->getKey());

        # toArray
        $this->assertEquals([], $resource->toArray());
    }

}

class StubBaseResourceTest extends BaseResource
{

}