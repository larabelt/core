<?php
namespace Ohio\Core\Http\Requests;

use Ohio\Core\Http\Requests\FormRequest;

class UpdateTeam extends FormRequest
{

    public function rules()
    {
        return [
            'name' => 'sometimes|required',
        ];
    }

}