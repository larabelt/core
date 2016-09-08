<?php
namespace Ohio\Core\UserRole;

use Ohio\Core;
use Ohio\Core\Base\BaseModel;
use Ohio\Core\Base\Http\Requests\BasePaginateRequest;

class UserRole extends BaseModel
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