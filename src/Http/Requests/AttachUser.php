<?php
namespace Ohio\Core\Http\Requests;

use Ohio\Core\Http\Requests\FormRequest;

class AttachUser extends FormRequest
{


    public function rules()
    {
        return [
            'id' => 'required|exists:users,id',
        ];
    }

}