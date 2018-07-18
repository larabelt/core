<?php

namespace Belt\Core\Forms\Contact;

use Belt, Mail;
use Belt\Core\Events\ItemCreated;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class NotificationListener
 * @package Belt\Core\Forms\Contact
 */
class NotificationListener implements ShouldQueue
{
    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 5;

    /**
     * Handle the event.
     *
     * @param  ItemCreated $event
     * @return void
     */
    public function handle(ItemCreated $event)
    {
        $form = $event->item();

        $recipient = config('mail.from.address');

        $mailable = new Notification($form);

        Mail::to($recipient)->send($mailable);
    }

}