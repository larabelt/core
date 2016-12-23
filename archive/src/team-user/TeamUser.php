<?php
namespace Ohio\Core\TeamUser;

use Ohio\Core;
use Illuminate\Database\Eloquent\Model;

class TeamUser extends Model
{

    protected $table = 'team_users';

    protected $guarded = ['id'];

    public static function create(array $attributes = [])
    {
        return static::firstOrCreate($attributes);
    }

    public function team()
    {
        return $this->belongsTo(Core\Team\Team::class);
    }

    public function user()
    {
        return $this->belongsTo(Core\User\User::class);
    }

}