<?php
namespace Belt\Core\Http\Requests;

use Belt\Core\Http\Requests\FormRequest;

class UpdateRole extends FormRequest
{

    public function rules()
    {
        return [
            'name' => 'sometimes|required',
        ];
    }

}