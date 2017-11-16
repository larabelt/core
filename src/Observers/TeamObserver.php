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
    public function saving(Team $team)
    {
        /**
         * If default user does not exist, add the first attached user.
         */
        if (!$team->default_user_id) {
            if ($user = $team->users->first()) {
                $team->default_user_id = $user->id;
            }
        }

        /**
         * Ensure the default user is attached as a user.
         */
        if ($team->default_user_id) {
            $team->users()->syncWithoutDetaching([$team->default_user_id]);
        }
    }
}