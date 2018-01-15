<?php

use Mockery as m;
use Belt\Core\Testing;
use Belt\Core\Events;
use Belt\Core\Listeners;
use Illuminate\Events\Dispatcher;

class UserEventSubscriberTest extends Testing\BeltTestCase
{

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Listeners\UserEventSubscriber::subscribe
     */
    public function test()
    {
        app()['config']->set('belt.core.users.send_welcome_email', true);

        $events = m::mock(Dispatcher::class);
        $events->shouldReceive('listen')
            ->with(Events\UserCreated::class, Listeners\SendUserWelcomeEmail::class)
            ->once()
            ->andReturnSelf();

        $subscriber = new Listeners\UserEventSubscriber();
        $subscriber->subscribe($events);
    }

}