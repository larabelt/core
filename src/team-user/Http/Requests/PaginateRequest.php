<?php
namespace Ohio\Core\TeamUser\Http\Requests;

use Ohio\Core\Base\Http\Requests\BasePaginateRequest;
use Illuminate\Database\Eloquent\Builder;

class PaginateRequest extends BasePaginateRequest
{
    public $perPage = 5;

    public $orderBy = 'team_users.id';

    public $sortable = [
        'team_users.id',
        'team_users.team_id',
        'team_users.user_id',
    ];

    public $searchable = [
        'team_users.team_id',
        'team_users.user_id',
    ];

    public function modifyQuery(Builder $query)
    {
        if ($this->get('team_id')) {
            $query->where('team_id', $this->get('team_id'));
        }

        if ($this->get('user_id')) {
            $query->where('user_id', $this->get('user_id'));
        }

        return $query;
    }

}