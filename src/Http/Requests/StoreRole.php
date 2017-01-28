<?php
namespace Ohio\Core\Http\Requests;

use Ohio\Core\Http\Requests\FormRequest;

class StoreRole extends FormRequest
{


    public function rules()
    {
        return [
            'name' => 'required|unique:roles,name',
        ];
    }

}