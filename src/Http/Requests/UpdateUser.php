<?php

namespace Belt\Core\Http\Requests;

use Belt;
use Illuminate\Validation\Rule;

/**
 * Class UpdateUser
 * @package Belt\Core\Http\Requests
 */
class UpdateUser extends Belt\Core\Http\Requests\FormRequest
{

    /**
     * @return array
     */
    public function rules()
    {
        $user = $this->route('user');
        $password = $this->get('password');
        $password_confirmation = $this->get('password_confirmation');

        return [
            'email' => [
                'sometimes',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => ($password || $password_confirmation) ? 'sometimes|confirmed|min:8' : '',
        ];
    }

}