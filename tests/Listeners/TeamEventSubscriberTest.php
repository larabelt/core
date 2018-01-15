<?php

use Mockery as m;
use Belt\Core\Testing;
use Belt\Core\Events;
use Belt\Core\Listeners;
use Illuminate\Events\Dispatcher;

class TeamEventSubscriberTest extends Testing\BeltTestCase
{

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Listeners\TeamEventSubscriber::subscribe
     */
    public function test()
    {
        app()['config']->set('belt.core.teams.send_welcome_email', true);

        $events = m::mock(Dispatcher::class);
        $events->shouldReceive('listen')
            ->with(Events\TeamCreated::class, Listeners\SendTeamWelcomeEmail::class)
            ->once()
            ->andReturnSelf();

        $subscriber = new Listeners\TeamEventSubscriber();
        $subscriber->subscribe($events);
    }

}