<?php
namespace Ohio\Core\TeamUser\Http\Requests;

use Ohio\Core\TeamUser\TeamUser;
use Ohio\Core\Base\Http\Requests\PaginateRequest;

use Illuminate\Database\Eloquent\Builder;

class PaginateTeamUsers extends PaginateRequest
{
    public $perPage = 5;

    public $orderBy = 'team_users.id';

    public $sortable = [
        'team_users.id',
        'team_users.team_id',
        'team_users.user_id',
        'users.id',
        'users.email',
        'users.first_name',
        'users.last_name',
    ];

    public $searchable = [
        'team_users.team_id',
        'team_users.user_id',
        'users.email',
        'users.first_name',
        'users.last_name',
    ];

    /**
     * @var TeamUser
     */
    public $teamUser;

    /**
     * @return TeamUser
     */
    public function teamUser()
    {
        return $this->teamUser ?: $this->teamUser = new TeamUser();
    }

    /**
     * @inheritdoc
     */
    public function modifyQuery(Builder $query)
    {
        $query->join('users', 'users.id', '=', 'team_users.user_id');

        if ($this->get('team_id')) {
            $query->where('team_id', $this->get('team_id'));
        }

        if ($this->get('user_id')) {
            $query->where('user_id', $this->get('user_id'));
        }

        return $query;
    }

    /**
     * @param $id
     * @return TeamUser|null
     */
    public function item($id)
    {
        return $this->teamUser()->with('user')->find($id);
    }

    /**
     * @inheritdoc
     */
    public function items(Builder $query)
    {
        $items = [];

        $ids = $query->get(['team_users.id']);
        foreach ($ids->pluck('id')->all() as $id) {
            $items[] = $this->item($id);
        }

        return $items;
    }

}