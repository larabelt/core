<?php
namespace Ohio\Core\Http\Requests;

use Ohio\Core\Http\Requests\FormRequest;

class AttachRole extends FormRequest
{


    public function rules()
    {
        return [
            'id' => 'required|exists:roles,id',
        ];
    }

}