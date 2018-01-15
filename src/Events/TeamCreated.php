<?php

namespace Belt\Core\Events;

use Belt\Core\Team;
use Illuminate\Queue\SerializesModels;

/**
 * Class TeamCreated
 * @package Belt\Core\Events
 */
class TeamCreated
{
    use SerializesModels;

    public $team;

    /**
     * Create a new event instance.
     *
     * @param  Team $team
     */
    public function __construct(Team $team)
    {
        $this->team = $team;
    }

}