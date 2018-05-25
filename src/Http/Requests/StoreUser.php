<?php

namespace Belt\Core\Http\Requests;

use Belt, Auth;

/**
 * Class StoreUser
 * @package Belt\Core\Http\Requests
 */
class StoreUser extends Belt\Core\Http\Requests\UserRequest
{

    /**
     * @return array
     */
    public function rules()
    {
        $rules = [
            'email' => 'email|required|unique:users,email',
            'email_unique' => 'unique:users,email',
            'first_name' => 'required',
            'last_name' => 'required',
            'password' => 'required|confirmed|min:8',
        ];

        if (!Auth::user()) {
            $rules['has_agreed'] = 'required';
        }

        return $rules;
    }

}