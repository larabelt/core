<?php
namespace Ohio\Core\UserRole;

use Ohio\Core;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{

    protected $table = 'user_roles';

    protected $guarded = ['id'];

    public static function create(array $attributes = [])
    {
        return static::firstOrCreate($attributes);
    }

    public function user()
    {
        return $this->belongsTo(Core\User\User::class);
    }

    public function role()
    {
        return $this->belongsTo(Core\Role\Role::class);
    }

}