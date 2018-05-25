<?php

namespace Belt\Core\Http\Requests;

use Belt, Auth;
use Belt\Core\User;

/**
 * Class StoreUser
 * @package Belt\Core\Http\Requests
 */
class StoreUser extends Belt\Core\Http\Requests\UserRequest
{
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'has_agreed.accepted' => 'Terms must be accepted to continue.',
        ];
    }

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
            'has_agreed' => 'required|accepted',
        ];

        if (Auth::user() && Auth::user()->can('*', User::class)) {
            $rules['has_agreed'] = '';
        }

        return $rules;
    }

}