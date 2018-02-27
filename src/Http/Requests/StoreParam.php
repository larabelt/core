<?php
namespace Belt\Core\Http\Requests;

/**
 * Class StoreParam
 * @package Belt\Core\Http\Requests
 */
class StoreParam extends FormRequest
{

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'paramable_type' => 'required',
            'paramable_id' => 'required',
            'key' => [
                'required',
                $this->ruleUnique('params', ['paramable_type', 'paramable_id', 'key']),
            ],
        ];
    }

}