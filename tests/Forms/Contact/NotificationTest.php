<?php

use Belt\Core\Testing\BeltTestCase;
use Belt\Core\Form;
use Belt\Core\Forms\Contact\Notification;

class FormsContactNotificationTest extends BeltTestCase
{

    /**
     * @covers \Belt\Core\Forms\Contact\Notification::__construct
     * @covers \Belt\Core\Forms\Contact\Notification::build
     */
    public function test()
    {
        $form = new Form(['config_key' => 'contact']);

        # construct
        $mailable = new Notification($form);

        # build
        $this->assertInstanceOf(\Illuminate\Mail\Mailable::class, $mailable->build());
    }

}