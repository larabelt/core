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
    public function extension()
    {
        return $this->service()->extension($this->get('subtype'));
    }

    /**
     * @return array
     */
    public function rules()
    {
        if ($this->extension()) {
            return $this->extension()->rules('store');
        }

        return [
            'subtype' => 'required|in:' . implode(',', $this->service()->subtypes()),
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        if ($this->extension()) {
            return $this->extension()->messages('store');
        }

        return [];
    }

}