<?php

namespace Ohio\Core\UserRole;

use Prettus\Validator\Contracts\ValidatorInterface;
use Ohio\Core\Base\BaseValidator;

class UserRoleValidator extends BaseValidator
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'user_id' => 'required',
            'role_id' => 'required',
        ],
    ];

}