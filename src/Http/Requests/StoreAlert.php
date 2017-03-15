<?php
namespace Belt\Core\Http\Requests;

/**
 * Class StoreAlert
 * @package Belt\Core\Http\Requests
 */
class StoreAlert extends FormRequest
{

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'body' => 'required',
            'ends_at' => 'after:starts_at',
        ];
    }

}