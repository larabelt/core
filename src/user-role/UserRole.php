<?php
namespace Ohio\Core\UserRole;

use Ohio\Core;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{

    protected $morphClass = 'UserRole';

    protected $table = 'user_roles';

    protected $guarded = ['id'];

    public static function create(array $attributes = [])
    {
        return static::firstOrCreate($attributes);
    }

    public function role()
    {
        return $this->belongsTo(Core\Role\Role::class);
    }

}