<?php
namespace Ohio\Core\Base\Http\Requests;

use Illuminate\Foundation\Http\FormRequest as BaseFormRequest;
use Illuminate\Validation\Rules;

class FormRequest extends BaseFormRequest
{

    public function wantsJson()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }

    public function authorize()
    {
        // Only allow logged in users
        // return \Auth::check();
        // Allows all users in
        return true;
    }

    public function ruleExists($table, $column, $routeParameters = [])
    {
        $params = [];
        foreach ($routeParameters as $routeParameter) {
            $params[$routeParameter] = $this->route($routeParameter);
        }

        $rule = new Rules\Exists($table, $column);

        foreach ($params as $key => $value) {
            $rule->where($key, $value);
        }

        return $rule;
    }

}