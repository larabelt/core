<?php
namespace Belt\Core\Http\Requests;

/**
 * Class UpdateAlert
 * @package Belt\Core\Http\Requests
 */
class UpdateAlert extends FormRequest
{

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'sometimes|required',
            'body' => 'sometimes|required',
            'ends_at' => 'after:starts_at',
        ];
    }

}