<?php

namespace Ohio\Core\Model\Role\Domain;

use Prettus\Validator\Contracts\ValidatorInterface;
use Ohio\Core\Domain\BaseValidator;

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