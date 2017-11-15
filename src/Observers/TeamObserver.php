<?php

namespace Belt\Core\Observers;

use Belt;
use Belt\Core\Team;

class TeamObserver
{
    /**
     * Listen to the team created $team.
     *
     * @param  team $team
     * @return void
     */
    public function created(Team $team)
    {
        //event(new Belt\Core\Events\TeamCreated($team));
    }

    /**
     * Listen to the team created $team.
     *
     * @param  team $team
     * @return void
     */
    public function saving(Team $team)
    {
        if (!$team->default_user_id) {
            if ($user = $team->users->first()) {
                $team->default_user_id = $user->id;
            }
        }
    }
}