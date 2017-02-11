<?php
namespace Ohio\Core;

use Ohio\Core\User;
use Ohio\Core\Behaviors\Sluggable;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{

    use Sluggable;

    protected $morphClass = 'teams';

    protected $table = 'teams';

    protected $fillable = ['name'];

    /**
     * Default values
     *
     * @var array
     */
    protected $attributes = [
        'is_active' => 1,
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'team_users', 'team_id', 'user_id');
    }

    public function setIsActiveAttribute($value)
    {
        $this->attributes['is_active'] = boolval($value);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtoupper(trim($value));
    }

}