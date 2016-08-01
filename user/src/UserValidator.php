<?php

namespace Ohio\Core\User;

use Prettus\Validator\Contracts\ValidatorInterface;
use Ohio\Core\Base\BaseValidator;

class UserValidator extends BaseValidator
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'email' => 'required|email',
        ],
        ValidatorInterface::RULE_UPDATE => [
            'email' => 'email',
        ],
    ];

}