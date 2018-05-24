<?php

use Belt\Core\Team;
use Belt\Core\User;
use Belt\Core\Mail\TeamWelcomeEmail;

class TeamWelcomeEmailTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @covers \Belt\Core\Mail\TeamWelcomeEmail::__construct
     * @covers \Belt\Core\Mail\TeamWelcomeEmail::build
     */
    public function test()
    {
        $team = factory(Team::class)->make();
        $user = factory(User::class)->make();
        $team->defaultUser = $user;

        $mail = new TeamWelcomeEmail([
            'team' => $team,
            'user' => $user,
        ]);
        $this->assertEquals($team, $mail->team);
        $this->assertEquals($user, $mail->user);

        $this->assertEmpty($mail->view);
        $this->assertEmpty($mail->textView);
        $mail->build();
        $this->assertNotEmpty($mail->view);
        $this->assertNotEmpty($mail->textView);
    }

}