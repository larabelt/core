<?php
namespace Belt\Core\Http\Requests;

use Belt\Core\Http\Requests\FormRequest;

class StoreTeam extends FormRequest
{

    public function rules()
    {
        return [
            'name' => 'required',
        ];
    }

}