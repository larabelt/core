<?php namespace Belt\Core\Behaviors;

use Belt\Core\Param;

trait Paramable
{

    public function params()
    {
        return $this->morphMany(Param::class, 'paramable');
    }

    public function saveParam($key, $value)
    {
        $param = $this->params->where('key', $key)->first();

        if ($param) {
            $param->update(['value' => $value]);
        } else {
            $param = $this->params()->save(new Param(['key' => $key, 'value' => $value]));
        }

        return $param;
    }

    public function param($key, $default = null)
    {

        $param = $this->params->where('key', $key)->first();

        return $param ? $param->value : $default;
    }

}