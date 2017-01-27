<?php
namespace Ohio\Core\User\Http\Requests;

use Ohio\Core\Base\Http\Requests\FormRequest;

class AttachRole extends FormRequest
{


    public function rules()
    {
        return [
            'id' => 'required|exists:roles,id',
        ];
    }

}