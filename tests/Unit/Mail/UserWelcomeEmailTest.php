<?php namespace Tests\Belt\Core\Unit\Mail;

use Belt\Core\Mail\UserWelcomeEmail;
use Belt\Core\User;

class UserWelcomeEmailTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @covers \Belt\Core\Mail\UserWelcomeEmail::__construct
     * @covers \Belt\Core\Mail\UserWelcomeEmail::build
     */
    public function test()
    {
        $user = factory(User::class)->make();

        $mail = new UserWelcomeEmail([
            'user' => $user,
        ]);
        $this->assertEquals($user, $mail->user);

        $this->assertEmpty($mail->view);
        $this->assertEmpty($mail->textView);
        $mail->build();
        $this->assertNotEmpty($mail->view);
        $this->assertNotEmpty($mail->textView);
    }

}