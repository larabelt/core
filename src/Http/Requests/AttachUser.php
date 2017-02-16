<?php
namespace Belt\Core\Http\Requests;

use Belt\Core\Http\Requests\FormRequest;

class AttachUser extends FormRequest
{


    public function rules()
    {
        return [
            'id' => 'required|exists:users,id',
        ];
    }

}