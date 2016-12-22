<?php
namespace Ohio\Core\Team\Http\Requests;

use Ohio\Core\Base\Http\Requests\FormRequest;

class StoreTeam extends FormRequest
{

    public function rules()
    {
        return [
            'name' => 'required',
        ];
    }

}