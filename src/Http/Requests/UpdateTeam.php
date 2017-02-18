<?php
namespace Belt\Core\Http\Requests;

/**
 * Class UpdateTeam
 * @package Belt\Core\Http\Requests
 */
class UpdateTeam extends FormRequest
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