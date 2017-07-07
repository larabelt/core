<?php namespace Belt\Core\Behaviors;

use Belt\Core\Param;

/**
 * Class Paramable
 * @package Belt\Core\Behaviors
 */
trait Paramable
{

    /**
     * @return mixed
     */
    public function params()
    {
        return $this->morphMany(Param::class, 'paramable')->orderBy('params.id');
    }

    /**
     * @param $key
     * @param $value
     * @return mixed
     */
    public function saveParam($key, $value)
    {
        $this->load('params');

        $param = $this->params->where('key', $key)->first();

        if ($param) {
            $param->update(['value' => $value]);
            //$this->purgeDuplicateParams($param);
        } else {
            $param = $this->params()->save(new Param(['key' => $key, 'value' => $value]));
        }

        return $param;
    }

    /**
     * @param $key
     * @param null $default
     * @return null
     */
    public function param($key, $default = null)
    {
        $param = $this->params->where('key', $key)->first();

        if ($param) {
            //$this->purgeDuplicateParams($param);
        }

        return $param ? $param->value : $default;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function paramQB()
    {
        return Param::query();
    }

    /**
     * @deprecated
     *
     * @param $param
     */
    public function purgeDuplicateParams($param)
    {
        $qb = $this->paramQB();
        $qb->where('id', '!=', $param->id);
        $qb->where('paramable_type', $param->paramable_type);
        $qb->where('paramable_id', $param->paramable_id);
        $qb->where('key', $param->key);

        foreach ($qb->get() as $duplicate) {
            $duplicate->delete();
        }
    }

}