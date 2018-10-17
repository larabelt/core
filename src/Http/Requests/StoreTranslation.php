<?php
namespace Belt\Core\Http\Requests;

/**
 * Class StoreTranslation
 * @package Belt\Core\Http\Requests
 */
class StoreTranslation extends FormRequest
{

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'locale' => 'required',
            'translatable_type' => 'required',
            'translatable_id' => 'required',
            'key' => [
                'required',
                $this->ruleUnique('translations', ['translatable_type', 'translatable_id', 'key', 'locale']),
            ],
        ];
    }

}