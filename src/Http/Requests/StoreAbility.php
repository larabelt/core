<?php

namespace Belt\Core\Http\Requests;

/**
 * Class StoreAbility
 * @package Belt\Core\Http\Requests
 */
class StoreAbility extends FormRequest
{

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'entity_type' => 'required',
        ];
    }

}