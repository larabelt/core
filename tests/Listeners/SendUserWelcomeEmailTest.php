<?php

use Mockery as m;
use Belt\Core\Events;
use Belt\Core\Listeners;
use Belt\Core\Mail\UserWelcomeEmail;
use Belt\Core\Testing;
use Belt\Core\User;
use Illuminate\Support\Facades\Mail;

class SendUserWelcomeEmailTest extends Testing\BeltTestCase
{

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Listeners\SendUserWelcomeEmail::__construct
     * @covers \Belt\Core\Listeners\SendUserWelcomeEmail::handle
     */
    public function test()
    {
        Mail::fake();

        $user = factory(User::class)->make();

        $event = new Events\UserCreated($user);

        $listener = new Listeners\SendUserWelcomeEmail();
        $listener->handle($event);

        $mailable = new UserWelcomeEmail([
            'user' => $user,
        ]);

        Mail::shouldReceive('to')->with($user->email);
        Mail::shouldReceive('send')->with($mailable);
    }

}