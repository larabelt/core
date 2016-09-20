<?php
namespace Ohio\Core\Role\Http\Requests;

use Ohio\Core\Base\Http\Requests\BaseFormRequest;

class CreateRequest extends BaseFormRequest
{


    public function rules()
    {
        return [
            'name' => 'required',
        ];
    }

}