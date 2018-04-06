<?php

namespace Belt\Core\Listeners;

use Belt, Mail;
use Belt\Core\Events\ItemCreated;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class UserWelcomeEmail
 * @package Belt\Core\Listeners
 */
class SendUserWelcomeEmail implements ShouldQueue
{
    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 5;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ItemCreated $event
     * @return void
     */
    public function handle(ItemCreated $event)
    {
        $user = $event->item();

        $mailable = new Belt\Core\Mail\UserWelcomeEmail([
            'user' => $user,
        ]);

        Mail::to($user->email)->send($mailable);
    }

}