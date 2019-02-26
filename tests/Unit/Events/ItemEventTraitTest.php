<?php namespace Tests\Belt\Core\Unit\Events;

use Belt\Core\Events\ItemEventInterface;
use Belt\Core\Events\ItemEventTrait;
use Belt\Core\Facades\MorphFacade as Morph;
use Tests\Belt\Core;
use Belt\Core\User;
use Illuminate\Support\Facades\Auth;
use Mockery as m;

class ItemEventTraitTest extends \Tests\Belt\Core\BeltTestCase
{

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Events\ItemEventTrait::__construct
     * @covers \Belt\Core\Events\ItemEventTrait::setName
     * @covers \Belt\Core\Events\ItemEventTrait::getName
     * @covers \Belt\Core\Events\ItemEventTrait::item
     * @covers \Belt\Core\Events\ItemEventTrait::setItemId
     * @covers \Belt\Core\Events\ItemEventTrait::getItemId
     * @covers \Belt\Core\Events\ItemEventTrait::setItemType
     * @covers \Belt\Core\Events\ItemEventTrait::getItemType
     * @covers \Belt\Core\Events\ItemEventTrait::user
     * @covers \Belt\Core\Events\ItemEventTrait::setUserID
     * @covers \Belt\Core\Events\ItemEventTrait::getUserID
     */
    public function test()
    {
        User::unguard();

        $user = factory(User::class)->make(['id' => 123]);
        $event = new ItemEventTraitStub($user, 'users.stubbed');

        # name
        $this->assertEquals('users.stubbed', $event->getName());

        # item
        $this->assertEquals(123, $event->getItemId());
        $this->assertEquals('users', $event->getItemType());
        Morph::shouldReceive('morph')->with('users', 123)->andReturn($user);
        $this->assertEquals($user, $event->item());

        # user

        $this->assertNull($event->user());
        $auth = factory(User::class)->make(['id' => 999]);
        $event->setUserID(999);
        $this->assertEquals(999, $event->getUserID());
        Morph::shouldReceive('morph')->with('users', 999)->andReturn($auth);
        $this->assertEquals($auth, $event->user());

        # user (null)
        Auth::shouldReceive('id')->andReturn(99999);
        $event = new ItemEventTraitStub($user, 'users.stubbed');
        $this->assertEquals(99999, $event->getUserID());

    }

}

class ItemEventTraitStub extends \Tests\Belt\Core\Base\BaseModelStub
    implements ItemEventInterface
{
    use ItemEventTrait;

    public function getMorphClass()
    {
        return 'test';
    }
}