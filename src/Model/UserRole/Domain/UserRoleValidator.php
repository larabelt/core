<?php

namespace Ohio\Core\Model\UserRole\Domain;

use Prettus\Validator\Contracts\ValidatorInterface;
use Ohio\Core\Domain\BaseValidator;

class UserRoleValidator extends BaseValidator
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'user_id' => 'required',
            'role_id' => 'required',
        ],
    ];

}