<?php namespace Ohio\Core\Behaviors;

trait ParamsTrait
{

    public $_params;

    public function params()
    {
        if (is_null($this->_params)) {
            $_params = [];
            foreach (explode("\n", $this->params) as $param) {
                $param = explode('=', $param);
                if (isset($param[1])) {
                    $_params[trim($param[0])] = trim($param[1]);
                }
            }
            $this->_params = $_params;
        }

        return $this->_params;
    }

    public function param($key, $default = null)
    {
        return array_get($this->params(), $key, $default);
    }

    public function setParamsAttribute($value)
    {

        if (is_array($value)) {
            $str = '';
            foreach ($value as $k => $v) {
                $str .= sprintf("%s=%s\n", $k, $v);
            };
            $value = $str;
        }

        $this->attributes['params'] = trim($value);
    }

}