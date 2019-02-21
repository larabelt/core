<?php namespace Tests\Belt\Core\Unit\Forms;

use Belt\Core\Events;
use Belt\Core\Facades\MorphFacade as Morph;
use Belt\Core\Form;
use Belt\Core\Forms\Contact\AutoResponderListener;
use Belt\Core\Tests\BeltTestCase;
use Illuminate\Support\Facades\Mail;

class FormsContactAutoResponderListenerTest extends BeltTestCase
{

    /**
     * @covers \Belt\Core\Forms\Contact\AutoResponderListener::handle
     */
    public function test()
    {
        Form::unguard();
        $form = new Form(['id' => 1, 'subtype' => 'contact']);
        $form->data = ['email' => 'foo@bar.com'];
        $event = new Events\ItemCreated($form);

        Morph::shouldReceive('morph')->with('forms', 1)->andReturn($form);

        Mail::shouldReceive('to')->with('foo@bar.com')->andReturnSelf();
        Mail::shouldReceive('send');

        $listener = new AutoResponderListener();
        $listener->handle($event);

    }

}