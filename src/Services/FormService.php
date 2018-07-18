<?php

namespace Belt\Core\Services;

use Belt\Core\Form;
use Belt\Core\Forms\BaseForm;

/**
 * Class FormService
 * @package Belt\Core\Services
 */
class FormService
{

    /**
     * @return array
     */
    public function keys()
    {
        $keys = array_keys(config('belt.forms', []));

        sort($keys);

        return $keys;
    }


    /**
     * @param $key
     * @param null $form
     * @return BaseForm
     */
    public function template($key, $form = null)
    {
        $class = config("belt.forms.$key.template");

        if ($class && class_exists($class)) {
            return new $class($form ?: new Form());
        }
    }

}