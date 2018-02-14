<?php

namespace Belt\Core\Http\Requests;

/**
 * Class StorePermission
 * @package Belt\Core\Http\Requests
 */
class StorePermission extends FormRequest
{

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'ability_id' => 'required|exists:abilities,id',
            'entity_type' => 'required',
            'entity_id' => 'required',
        ];
    }

}