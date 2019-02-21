<?php namespace Tests\Belt\Core\Unit\Listeners;

use Belt\Core\Events;
use Belt\Core\Facades\MorphFacade as Morph;
use Belt\Core\Listeners;
use Belt\Core\Mail\UserWelcomeEmail;
use Belt\Core\Tests;
use Belt\Core\User;
use Illuminate\Support\Facades\Mail;
use Mockery as m;

class SendUserWelcomeEmailTest extends Tests\BeltTestCase
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
        User::unguard();

        $user = factory(User::class)->make(['id' => 123]);

        $event = new Events\ItemCreated($user);

        Morph::shouldReceive('morph')->with('users', 123)->andReturn($user);

        $listener = new Listeners\SendUserWelcomeEmail();
        $listener->handle($event);

        $mailable = new UserWelcomeEmail([
            'user' => $user,
        ]);

        Mail::shouldReceive('to')->with($user->email);
        Mail::shouldReceive('send')->with($mailable);
    }

}