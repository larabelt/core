<?php

namespace Belt\Core\Http\Requests;

use Belt\Core\Http\Requests\FormRequest;

class AttachRole extends FormRequest
{
    public function rules()
    {
        return [
            'id' => 'required|exists:roles,id',
        ];
    }

}