<?php
namespace Ohio\Core\Team\Http\Requests;

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