<?php
namespace Ohio\Core\Team\Http\Requests;

use Ohio\Core\User\User;
use Ohio\Core\User\Http\Requests\PaginateUsers as PaginateRequest;
use Illuminate\Database\Eloquent\Builder;

class PaginateUsers extends PaginateRequest
{
    /**
     * @var User
     */
    public $userRepo;

    /**
     * @return User
     */
    public function userRepo()
    {
        return $this->userRepo ?: $this->userRepo = new User();
    }

    /**
     * @inheritdoc
     */
    public function modifyQuery(Builder $query)
    {
        # show users on team
        if (!$this->get('not')) {
            $query->join('team_users', 'team_users.user_id', '=', 'users.id');
            $query->where('team_users.team_id', $this->get('team_id'));
        }

        # show users not on team
        if ($this->get('not')) {
            $query->leftJoin('team_users', function ($subQB) {
                $subQB->on('team_users.user_id', '=', 'users.id');
                $subQB->where('team_users.team_id', $this->get('team_id'));
            });
            $query->whereNull('team_users.id');
        }

        return $query;
    }

    /**
     * @inheritdoc
     */
    public function items(Builder $query)
    {
        $items = [];

        $ids = $query->get(['users.id']);
        foreach ($ids->pluck('id')->all() as $id) {
            $items[] = $this->item($id);
        }

        return $items;
    }

    public function item($id)
    {
        return $this->userRepo()->find($id);
    }

}