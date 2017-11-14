<?php
namespace Belt\Core\Http\Requests;

/**
 * Class StoreUser
 * @package Belt\Core\Http\Requests
 */
class StoreUser extends FormRequest
{

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'email|required|unique:users,email',
            //'first_name' => 'required',
            //'last_name' => 'required',
            'password' => 'required|confirmed|min:8',
        ];
    }

}