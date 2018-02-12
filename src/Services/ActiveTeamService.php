<?php

namespace Belt\Core\Services;

use Auth, Session;
use Belt\Core\Team;
use Belt\Core\User;
use Illuminate\Http\Request;

/**
 * Class ActiveTeamService
 * @package Belt\Core\Services
 */
class ActiveTeamService
{
    /**
     * The team for this UI
     *
     * @var Team
     */
    private static $team;

    /**
     * @var Request
     */
    public $request;

    /**
     * @var User
     */
    public $user;

    /**
     * @var \Illuminate\Database\Eloquent\Builder
     */
    public $teamQB;

    /**
     * ActiveTeamService constructor.
     * @param array $params
     */
    public function __construct($params = [])
    {
        $this->user = array_get($params, 'user') ?? Auth::user() ?? new User();

        $this->request = array_get($params, 'request', new Request());
    }

    /**
     * @return Team
     */
    public static function team()
    {
        return static::$team;
    }

    /**
     * @return integer|null
     */
    public function getActiveTeamId()
    {
        //return $this->request->get('active_team_id') ?: Session::get('active_team_id');
        return $this->request->query->get('team_id') ?: Session::get('active_team_id');
    }

    /**
     * @param $team_id
     * @return bool
     */
    public function isAuthorized($team_id)
    {
        if ($this->user->is_super) {
            return true;
        }

        return $this->user->activeTeams->contains($team_id);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function teamQB()
    {
        return $this->teamQB ?: $this->teamQB = Team::query();
    }

    /**
     * @param mixed $team
     */
    public function setTeam($team)
    {
        $team = $team instanceof Team ? $team : $this->teamQB()->find($team);

        static::$team = $team;

        Session::put('active_team_id', $team->id);

        //if ($this->request && in_array($this->request->method(), ['POST', 'PUT'])) {
        if ($this->request) {
            $this->request->merge(['team_id' => $team->id]);
        }
    }

    /**
     * @return Team|null
     */
    public function getDefaultTeamId()
    {
        if ($this->user->activeTeams->count()) {
            return $this->user->activeTeams->first()->id;
        }
    }


    /**
     * remove 'active_team_id' from Session
     */
    public function forgetTeam()
    {
        static::$team = null;

        Session::forget('active_team_id');
    }

}