<?php

namespace Ohio\Core\Role;

use Prettus\Validator\Contracts\ValidatorInterface;
use Ohio\Core\Base\BaseValidator;

class RoleValidator extends BaseValidator
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name' => 'required',
        ],
        ValidatorInterface::RULE_UPDATE => [

        ],
    ];

}