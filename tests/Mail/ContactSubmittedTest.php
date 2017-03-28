<?php

use Belt\Core\Mail\ContactSubmitted;

class ContactSubmittedTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers \Belt\Core\Mail\ContactSubmitted::__construct
     * @covers \Belt\Core\Mail\ContactSubmitted::build
     */
    public function test()
    {

        $mail = new ContactSubmitted([
            'name' => 'tester',
            'email' => 'tester@testing.com',
            'comments' => 'test',
        ]);
        $this->assertEquals('tester', $mail->name);
        $this->assertEquals('tester@testing.com', $mail->email);
        $this->assertEquals('test', $mail->comments);

        $this->assertEmpty($mail->view);
        $this->assertEmpty($mail->textView);
        $mail->build();
        $this->assertNotEmpty($mail->view);
        $this->assertNotEmpty($mail->textView);
    }

}