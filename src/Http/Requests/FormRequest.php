<?php

namespace Belt\Core\Http\Requests;

use Belt;
use Illuminate\Foundation\Http\FormRequest as BaseFormRequest;
use Illuminate\Validation\Rules;

class FormRequest extends BaseFormRequest implements
    Belt\Core\Http\Requests\BaseRequestInterface
{

    use Belt\Core\Http\Requests\BaseRequest;

    /**
     * @return bool
     */
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

    /**
     * @return bool
     */
    public function authorize()
    {
        // Only allow logged in users
        // return \Auth::check();
        // Allows all users in
        return true;
    }

    /**
     * @param $table
     * @param $column
     * @param array $routeParameters
     * @return Rules\Exists
     */
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

    /**
     * @param $table
     * @param array $columns
     * @return Rules\Unique
     */
    public function ruleUnique($table, $columns = [])
    {

        $rule = new Rules\Unique($table);
        $rule->where(function ($query) use ($columns) {
            foreach ($columns as $column) {
                $query->where($column, $this->get($column));
            }
        });

        return $rule;
    }

}