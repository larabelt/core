<?php

namespace Belt\Core\Http\Requests;

/**
 * Class UpdateForm
 * @package Belt\Core\Http\Requests
 */
class UpdateForm extends StoreForm
{
    /**
     * @return array
     */
    public function rules()
    {
        return $this->route('form')->template()->rules('update');
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return $this->route('form')->template()->messages('update');
    }

}