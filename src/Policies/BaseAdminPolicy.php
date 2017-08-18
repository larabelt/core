<?php

namespace Belt\Core\Policies;

use Belt\Core\Behaviors\TeamableInterface;
use Belt\Core\User;
use Belt\Core\Team;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;
use Belt\Core\Services\ActiveTeamService;

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

    public function teamService()
    {
        return $this->teamService ?: $this->teamService = new ActiveTeamService();
    }

    /**
     * @param $user
     * @param $ability
     * @return bool
     */
    public function before($user, $ability)
    {
        if ($user->hasRole('ADMIN')) {
            return true;
        }
    }

    /**
     * Determine whether the user can view list of objects
     *
     * @param  User $auth
     * @return mixed
     */
    public function index(User $auth)
    {

    }

    /**
     * Determine whether the user can view the object.
     *
     * @param  User $auth
     * @param  Model $object
     * @return mixed
     */
    public function view(User $auth, $object)
    {
        if ($object instanceof TeamableInterface) {
            return $this->ofTeam($auth, $object->team);
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
     * @param  Model $object
     * @return mixed
     */
    public function update(User $auth, $object)
    {
        if ($object instanceof TeamableInterface) {
            return $this->ofTeam($auth, $object->team);
        }
    }

    /**
     * Determine whether the user can delete the object.
     *
     * @param  User $auth
     * @param  Model $object
     * @return mixed
     */
    public function delete(User $auth, $object)
    {
        if ($object instanceof TeamableInterface) {
            return $this->ofTeam($auth, $object->team);
        }
    }

    /**
     * Determine if user is of team
     *
     * @param User $auth
     * @param Team $team
     * @return bool
     */
    public function ofTeam(User $auth, Team $team)
    {
        $this->teamService()->user = $auth;

        if ($this->teamService()->isAuthorized($team->id)) {
            return true;
        }
    }
}
