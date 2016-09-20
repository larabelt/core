<?php
namespace Ohio\Core\User\Http\Requests;

use Ohio\Core\Base\Http\Requests\BaseFormRequest;

class CreateRequest extends BaseFormRequest
{


    public function rules()
    {
        return [
            'email' => 'email|required',
            'first_name' => 'required',
        ];
    }

}