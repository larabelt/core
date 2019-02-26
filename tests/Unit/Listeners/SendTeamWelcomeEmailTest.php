<?php namespace Tests\Belt\Core\Unit\Listeners;

use Belt\Core\Events;
use Belt\Core\Facades\MorphFacade as Morph;
use Belt\Core\Listeners;
use Belt\Core\Mail\TeamWelcomeEmail;
use Belt\Core\Team;
use Tests\Belt\Core;
use Belt\Core\User;
use Illuminate\Support\Facades\Mail;
use Mockery as m;

class SendTeamWelcomeEmailTest extends \Tests\Belt\Core\BeltTestCase
{

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Listeners\SendTeamWelcomeEmail::__construct
     * @covers \Belt\Core\Listeners\SendTeamWelcomeEmail::handle
     */
    public function test()
    {
        Team::unguard();
        Mail::fake();

        $team = factory(Team::class)->make(['id' => 123]);
        $user = factory(User::class)->make();
        $team->defaultUser = $user;

        $event = new Events\ItemCreated($team);

        Morph::shouldReceive('morph')->with('teams', 123)->andReturn($team);

        $listener = new Listeners\SendTeamWelcomeEmail();
        $listener->handle($event);

        $mailable = new TeamWelcomeEmail([
            'team' => $team,
        ]);

        Mail::shouldReceive('to')->with($user->email);
        Mail::shouldReceive('send')->with($mailable);
    }

}