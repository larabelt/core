<?php

namespace Belt\Core\Listeners;

use Belt, Mail;
use Belt\Core\Events\UserCreated;
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
     * @param  UserCreated $event
     * @return void
     */
    public function handle(UserCreated $event)
    {
        $user = $event->morph();

        $mailable = new Belt\Core\Mail\UserWelcomeEmail([
            'user' => $user,
        ]);

        Mail::to($user->email)->send($mailable);
    }

}