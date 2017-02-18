<?php
namespace Belt\Core\Http\Requests;

/**
 * Class UpdateRole
 * @package Belt\Core\Http\Requests
 */
class UpdateRole extends FormRequest
{

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'sometimes|required',
        ];
    }

}