<?php
namespace Belt\Core\Http\Requests;

/**
 * Class StoreTeam
 * @package Belt\Core\Http\Requests
 */
class StoreTeam extends FormRequest
{

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
        ];
    }

}