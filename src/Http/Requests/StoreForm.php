<?php

namespace Belt\Core\Http\Requests;

use Belt\Core\Forms\BaseForm;
use Belt\Core\Services\FormService;

/**
 * Class StoreForm
 * @package Belt\Core\Http\Requests
 */
class StoreForm extends FormRequest
{

    /**
     * @var FormService
     */
    public $service;

    /**
     * @var BaseForm
     */
    public $template;

    /**
     * @return FormService
     */
    public function service()
    {
        return $this->service ?: $this->service = new FormService();
    }

    /**
     * @return \Belt\Core\Forms\BaseForm
     */
    public function template()
    {
        return $this->service()->template($this->get('config_key'));
    }

    /**
     * @return array
     */
    public function rules()
    {
        if ($this->template()) {
            return $this->template()->rules('store');
        }

        return [
            'config_key' => 'required|in:' . implode(',', $this->service()->keys()),
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        if ($this->template()) {
            return $this->template()->messages('store');
        }

        return [];
    }

}