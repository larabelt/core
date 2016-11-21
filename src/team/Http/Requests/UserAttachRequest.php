<?php
namespace Ohio\Core\Team\Http\Requests;

use Ohio\Core\Base\Http\Requests\BaseFormRequest;

class UserAttachRequest extends BaseFormRequest
{


    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
        ];
    }

}