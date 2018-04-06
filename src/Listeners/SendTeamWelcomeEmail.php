<?php

namespace Belt\Core\Listeners;

use Belt, Mail;
use Belt\Core\Team;
use Belt\Core\Events\ItemCreated;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class TeamWelcomeEmail
 * @package Belt\Core\Listeners
 */
class SendTeamWelcomeEmail implements ShouldQueue
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
        /* @var $team Team */
        $team = $event->item();
        $user = $team->defaultUser;

        $mailable = new Belt\Core\Mail\TeamWelcomeEmail([
            'team' => $team,
            'user' => $user,
        ]);

        Mail::to($user->email)->send($mailable);
    }

}