<?php

namespace Belt\Core\Listeners;

use Belt, Mail;
use Belt\Core\Events\TeamCreated;
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
     * @param  TeamCreated $event
     * @return void
     */
    public function handle(TeamCreated $event)
    {
        $team = $event->team;
        $user = $event->team->defaultUser;

        $mailable = new Belt\Core\Mail\TeamWelcomeEmail([
            'team' => $team,
            'user' => $user,
        ]);

        Mail::to($user->email)->send($mailable);
    }

}