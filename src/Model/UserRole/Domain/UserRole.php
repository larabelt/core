<?php
namespace Ohio\Core\Model\UserRole\Domain;

use Ohio\Core\Domain\BaseModel;

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