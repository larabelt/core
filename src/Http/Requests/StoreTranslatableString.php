<?php
namespace Belt\Core\Http\Requests;

/**
 * Class StoreTranslatableString
 * @package Belt\Core\Http\Requests
 */
class StoreTranslatableString extends FormRequest
{

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'value' => 'required|unique:translatable_strings,value',
        ];
    }

}