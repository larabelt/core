<?php

namespace Belt\Core\Listeners;

use Belt, Illuminate;
use Belt\Core\Events;
use Belt\Core\Listeners;

/**
 * Class TeamEventSubscriber
 * @package Belt\Core\Listeners
 */
class TeamEventSubscriber
{
    /**
     * Register the listeners for the subscriber.
     *
     * @param Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        if (config('belt.core.teams.send_welcome_email')) {
            $events->listen(Events\TeamCreated::class, Listeners\SendTeamWelcomeEmail::class);
        }
    }

}