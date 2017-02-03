<?php
namespace Ohio\Core\Http\Requests;

class UpdateParam extends FormRequest
{

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