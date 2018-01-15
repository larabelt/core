<?php

namespace Belt\Core\Events;

use Belt\Core\User;
use Illuminate\Queue\SerializesModels;

/**
 * Class UserCreated
 * @package Belt\Core\Events
 */
class UserCreated
{
    use SerializesModels;

    public $user;

    /**
     * Create a new event instance.
     *
     * @param  User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

}