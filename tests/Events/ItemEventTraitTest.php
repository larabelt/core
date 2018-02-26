<?php

use Mockery as m;
use Belt\Core\User;
use Belt\Core\Testing;
use Belt\Core\Events\ItemEventTrait;
use Belt\Core\Events\ItemEventInterface;
use Belt\Core\Facades\MorphFacade as Morph;

class ItemEventTraitTest extends Testing\BeltTestCase
{

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Events\ItemEventTrait::__construct
     * @covers \Belt\Core\Events\ItemEventTrait::item
     * @covers \Belt\Core\Events\ItemEventTrait::setId
     * @covers \Belt\Core\Events\ItemEventTrait::getId
     * @covers \Belt\Core\Events\ItemEventTrait::setType
     * @covers \Belt\Core\Events\ItemEventTrait::getType
     */
    public function test()
    {
        User::unguard();

        $user = factory(User::class)->make(['id' => 123]);
        $event = new ItemEventTraitStub($user);

        # id
        $this->assertEquals(123, $event->getId());

        # type
        $this->assertEquals('users', $event->getType());

        # item
        Morph::shouldReceive('morph')->with('users', 123)->andReturn($user);
        $event->item();

    }

}

class ItemEventTraitStub extends Testing\BaseModelStub
    implements ItemEventInterface
{
    use ItemEventTrait;

    public function getMorphClass()
    {
        return 'test';
    }
}