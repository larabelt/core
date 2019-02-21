<?php namespace Tests\Belt\Core\Unit\Forms;

use Belt\Core\Events;
use Belt\Core\Facades\MorphFacade as Morph;
use Belt\Core\Form;
use Belt\Core\Forms\Contact\NotificationListener;
use Belt\Core\Tests\BeltTestCase;
use Illuminate\Support\Facades\Mail;

class FormsContactNotificationListenerTest extends BeltTestCase
{

    /**
     * @covers \Belt\Core\Forms\Contact\NotificationListener::handle
     */
    public function test()
    {
        app()['config']->set('mail.from.address', 'support@larabelt.org');

        Form::unguard();
        $form = new Form(['id' => 1, 'subtype' => 'contact']);
        $form->data = ['email' => 'foo@bar.com'];
        $event = new Events\ItemCreated($form);

        Morph::shouldReceive('morph')->with('forms', 1)->andReturn($form);

        Mail::shouldReceive('to')->with('support@larabelt.org')->andReturnSelf();
        Mail::shouldReceive('send');

        $listener = new NotificationListener();
        $listener->handle($event);

    }

}