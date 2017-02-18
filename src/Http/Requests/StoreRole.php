<?php
namespace Belt\Core\Http\Requests;

/**
 * Class StoreRole
 * @package Belt\Core\Http\Requests
 */
class StoreRole extends FormRequest
{

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:roles,name',
        ];
    }

}