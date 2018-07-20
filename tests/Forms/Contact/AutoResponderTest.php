<?php

use Belt\Core\Testing\BeltTestCase;
use Belt\Core\Form;
use Belt\Core\Forms\Contact\AutoResponder;

class FormsContactAutoResponderTest extends BeltTestCase
{

    /**
     * @covers \Belt\Core\Forms\Contact\AutoResponder::__construct
     * @covers \Belt\Core\Forms\Contact\AutoResponder::build
     */
    public function test()
    {
        $form = new Form(['subtype' => 'contact']);

        # construct
        $mailable = new AutoResponder($form);

        # build
        $this->assertInstanceOf(\Illuminate\Mail\Mailable::class, $mailable->build());
    }

}