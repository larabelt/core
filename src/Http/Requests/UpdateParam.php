<?php
namespace Belt\Core\Http\Requests;

/**
 * Class UpdateParam
 * @package Belt\Core\Http\Requests
 */
class UpdateParam extends FormRequest
{

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'paramable_id' => 'sometimes|required',
            'paramable_type' => 'sometimes|required',
            'key' => 'sometimes|required',
            'value' => 'sometimes|required',
        ];
    }

}