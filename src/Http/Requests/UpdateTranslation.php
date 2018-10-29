<?php

namespace Belt\Core\Http\Requests;

/**
 * Class UpdateTranslation
 * @package Belt\Core\Http\Requests
 */
class UpdateTranslation extends FormRequest
{

    /**
     * @return array
     */
    public function rules()
    {
        return [
            //'value' => 'sometimes|required',
        ];
    }

}