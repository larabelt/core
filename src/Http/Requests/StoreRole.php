<?php
namespace Belt\Core\Http\Requests;

use Belt\Core\Http\Requests\FormRequest;

class StoreRole extends FormRequest
{


    public function rules()
    {
        return [
            'name' => 'required|unique:roles,name',
        ];
    }

}