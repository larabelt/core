<?php
namespace Belt\Core\Http\Requests;

/**
 * Class UpdateTranslatableString
 * @package Belt\Core\Http\Requests
 */
class UpdateTranslatableString extends FormRequest
{

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'value' => 'sometimes|required',
        ];
    }

}