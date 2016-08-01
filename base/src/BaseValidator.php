<?php

namespace Ohio\Core\Base;

use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class BaseValidator extends LaravelValidator {

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [],
        ValidatorInterface::RULE_UPDATE => [],
   ];

}