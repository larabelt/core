<?php
namespace Belt\Core\Http\Requests;

/**
 * Class UpdateAbility
 * @package Belt\Core\Http\Requests
 */
class UpdateAbility extends FormRequest
{

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'sometimes|required',
            'entity_type' => 'sometimes|required',
        ];
    }

}