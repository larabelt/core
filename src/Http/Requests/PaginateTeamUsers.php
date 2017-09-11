<?php

namespace Belt\Core\Http\Requests;

use Belt;
use Belt\Core\User;
use Belt\Core\Http\Requests\PaginateUsers as PaginateRequest;
use Illuminate\Database\Eloquent\Builder;

class PaginateTeamUsers extends PaginateRequest
{

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    public $modelClass = Belt\Core\User::class;

    /**
     * @var Belt\Core\Pagination\PaginationQueryModifier[]
     */
    public $queryModifiers = [];

    /**
     * @inheritdoc
     */
    public function modifyQuery(Builder $query)
    {
        # show users on team
        if (!$this->get('not')) {
            $this->joins['team_users'] = function ($qb) {
                $qb->join('team_users', 'team_users.user_id', '=', 'users.id');
            };
            $query->where('team_users.team_id', $this->get('team_id'));
        }

        # show users not on team
        if ($this->get('not')) {
            $this->joins['team_users'] = function ($qb, $request) {
                $qb->leftJoin('team_users', function ($sub) use ($request) {
                    $sub->on('team_users.user_id', '=', 'users.id');
                    $sub->where('team_users.team_id', $request->get('team_id'));
                });
            };
            $query->whereNull('team_users.id');
        }

        return $query;
    }

}