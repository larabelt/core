<?php

namespace Ohio\Core\Model\User\Domain;

use Prettus\Validator\Contracts\ValidatorInterface;
use Ohio\Core\Domain\BaseValidator;

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