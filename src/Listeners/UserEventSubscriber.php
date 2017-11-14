<?php

namespace Belt\Core\Listeners;

use Belt, Illuminate;
use Belt\Core\Events;
use Belt\Core\Listeners;


/**
 * Class UserEventSubscriber
 * @package Belt\Core\Listeners
 */
class UserEventSubscriber
{
    /**
     * Register the listeners for the subscriber.
     *
     * @param Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        if (config('belt.core.users.send_welcome_email')) {
            $events->listen(Events\UserCreated::class, Listeners\SendUserWelcomeEmail::class);
        }
    }

}