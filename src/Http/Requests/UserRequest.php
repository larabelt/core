<?php

namespace Belt\Core\Http\Requests;

/**
 * Class UserRequest
 * @package Belt\Core\Http\Requests
 */
class UserRequest extends FormRequest
{

    /**
     * @return array
     */
    public function all()
    {
        $data = parent::all();

        # add this value for additional validation, to be used by json error messaging
        $data['email_unique'] = array_get($data, 'email');

        return $data;
    }

}