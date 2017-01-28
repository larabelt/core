<?php
namespace Ohio\Core\Http\Requests;

use Ohio\Core\Http\Requests\FormRequest;

class StoreTeam extends FormRequest
{

    public function rules()
    {
        return [
            'name' => 'required',
        ];
    }

}