<?php
namespace Ohio\Core\Role\Http\Requests;

use Ohio\Core\Base\Http\Requests\FormRequest;

class StoreRole extends FormRequest
{


    public function rules()
    {
        return [
            'name' => 'required',
        ];
    }

}