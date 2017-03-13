<?php
namespace Belt\Core\Http\Requests;

/**
 * Class PostContact
 * @package Belt\Core\Http\Requests
 */
class PostContact extends FormRequest
{

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'email|required',
            'name' => 'required',
            'comments' => 'required',
        ];
    }

}