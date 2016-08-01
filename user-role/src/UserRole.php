<?php
namespace Ohio\Core\UserRole;

use Ohio\Core\Base\BaseModel;

class UserRole extends BaseModel
{

    protected $morphClass = 'UserRole';

    protected $table = 'users_roles';

    protected $guarded = ['id'];

    public function __toString()
    {
        return (string) $this->name;
    }

}