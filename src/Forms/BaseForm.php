<?php

namespace Belt\Core\Forms;

use Belt\Core\Form;
use Illuminate;

abstract class BaseForm
{
    /**
     * @var Form
     */
    protected $form;

    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * @var array
     */
    protected $rules = [
        'store' => [],
        'update' => [],
    ];

    /**
     * @var array
     */
    protected $messages = [
        'store' => [],
        'update' => [],
    ];

    /**
     * BaseForm constructor.
     * @param Form $form
     */
    public function __construct(Form $form)
    {
        $this->form = $form;
    }

    /**
     * @param $method
     * @return mixed
     */
    public function rules($method)
    {
        return (array) array_get($this->rules, $method);
    }

    /**
     * @param $method
     * @return mixed
     */
    public function messages($method)
    {
        return (array) array_get($this->messages, $method);
    }

    /**
     * @param array $input
     * @param Form|null $form
     * @return array
     */
    public function data(array $input = [], Form $form = null)
    {
        $form = $form ?: $this->form;

        $data = [];

        foreach ($this->attributes as $key => $values) {

            $data[$key] = $form->data($key) ?? null;

            if (array_key_exists($key, $input)) {
                $default = is_array($values) ? $values[0] : $values;
                $data[$key] = array_get($input, $key) ?: $default;
            }
        }

        return $data;
    }

}