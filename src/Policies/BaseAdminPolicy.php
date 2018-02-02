<?php

namespace Belt\Core\Policies;

use Belt\Core\Behaviors\TeamableInterface;
use Belt\Core\User;
use Belt\Core\Team;
use Belt\Core\Services\ActiveTeamService;
use Belt\Core\Services\PermissibleService;
use Belt\Core\Services\PermissibleServiceTrait;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseAdminPolicy
 * @package Belt\Core\Policies
 */
class BaseAdminPolicy
{
    use HandlesAuthorization;

    /**
     * @var ActiveTeamService
     */
    public $teamService;

    /**
     * @return ActiveTeamService
     */
    public function teamService()
    {
        return $this->teamService ?: $this->teamService = new ActiveTeamService();
    }

    /**
     * Determine whether the user can view the object.
     *
     * @param  User $auth
     * @param  mixed $arguments
     * @return mixed
     */
    public function view(User $auth, $arguments = null)
    {
        if ($arguments instanceof TeamableInterface) {
            return $this->ofTeam($auth, $arguments->team);
        }
    }

    /**
     * Determine whether the user can create object.
     *
     * @param  User $auth
     * @return mixed
     */
    public function create(User $auth)
    {
        $team = $this->teamService()->team();

        if ($team) {
            return $this->ofTeam($auth, $team);
        }

    }

    /**
     * Determine whether the user can update the object.
     *
     * @param  User $auth
     * @param  mixed $arguments
     * @return mixed
     */
    public function update(User $auth, $arguments = null)
    {
        if ($arguments instanceof TeamableInterface) {
            return $this->ofTeam($auth, $arguments->team);
        }
    }

    /**
     * Determine whether the user can delete the object.
     *
     * @param  User $auth
     * @param  mixed $arguments
     * @return mixed
     */
    public function delete(User $auth, $arguments = null)
    {
        if ($arguments instanceof TeamableInterface) {
            return $this->ofTeam($auth, $arguments->team);
        }
    }

    /**
     * Determine if user is of team
     *
     * @param User $auth
     * @param Team $team
     * @return bool
     */
    public function ofTeam(User $auth, Team $team = null)
    {
        if ($team) {
            $this->teamService()->user = $auth;
            if ($this->teamService()->isAuthorized($team->id)) {
                return true;
            }
        }
    }
}
