<?php

namespace Belt\Core\Forms\Contact;

use Belt;

/**
 * Class Template
 * @package Belt\Core\Forms\Contact
 */
class Extension extends Belt\Core\Forms\BaseForm
{

    /**
     * @var array
     */
    protected $attributes = [
        'name' => '',
        'email' => '',
        'comments' => '',
    ];

    /**
     * @var array
     */
    protected $rules = [
        'store' => [
            'name' => 'required',
            'email' => 'required|email',
            'comments' => 'required',
        ],
    ];

}