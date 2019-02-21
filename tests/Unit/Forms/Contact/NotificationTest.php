<?php namespace Tests\Belt\Core\Unit\Forms;

use Belt\Core\Form;
use Belt\Core\Forms\Contact\Notification;
use Belt\Core\Tests\BeltTestCase;

class FormsContactNotificationTest extends BeltTestCase
{

    /**
     * @covers \Belt\Core\Forms\Contact\Notification::__construct
     * @covers \Belt\Core\Forms\Contact\Notification::build
     */
    public function test()
    {
        $form = new Form(['subtype' => 'contact']);

        # construct
        $mailable = new Notification($form);

        # build
        $this->assertInstanceOf(\Illuminate\Mail\Mailable::class, $mailable->build());
    }

}