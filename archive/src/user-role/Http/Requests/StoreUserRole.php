<?php
namespace Ohio\Core\UserRole\Http\Requests;

use Ohio\Core\Base\Http\Requests\FormRequest;

class StoreUserRole extends FormRequest
{
    
    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id',
        ];
    }

}