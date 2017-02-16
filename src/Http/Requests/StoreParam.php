<?php
namespace Belt\Core\Http\Requests;

use Illuminate\Validation\Rule;

class StoreParam extends FormRequest
{

    public function rules()
    {
        return [
            'paramable_type' => 'required',
            'paramable_id' => 'required',
            'key' => [
                'required',
                $this->ruleUnique('params', ['paramable_type', 'paramable_id', 'key']),
            ],
            'value' => 'required',
        ];
    }

}