<?php
namespace Ohio\Core\User\Http\Requests;

use Ohio\Core\Base\Http\Requests\FormRequest;

class StoreUser extends FormRequest
{


    public function rules()
    {
        return [
            'email' => 'email|required|unique:users,email',
            'first_name' => 'required',
            'last_name' => 'required',
            'password' => 'required|confirmed|min:8',
        ];
    }

}