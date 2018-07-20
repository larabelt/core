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
    public function subtypes()
    {
        $subtypes = array_keys(config('belt.subtypes.forms', []));

        sort($subtypes);

        return $subtypes;
    }


    /**
     * @param $subtype
     * @param null $form
     * @return BaseForm
     */
    public function extension($subtype, $form = null)
    {
        $class = config("belt.subtypes.forms.$subtype.extension");

        if ($class && class_exists($class)) {
            return new $class($form ?: new Form());
        }
    }

}