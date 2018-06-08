<?php namespace Belt\Core\Behaviors;

use Morph;
use Belt\Core\Param;
use Belt\Core\Observers\ParamableObserver;

/**
 * Class Paramable
 * @package Belt\Core\Behaviors
 */
trait Paramable
{

    /**
     * Binds events to subclass
     */
    public static function bootParamable()
    {
        static::observe(ParamableObserver::class);
    }

    /**
     * @return mixed
     */
    public function params()
    {
        return $this->morphMany(Param::class, 'paramable');
        //return $this->morphMany(Param::class, 'paramable')->orderBy('params.key');
    }

    /**
     * @param $key
     * @param $value
     * @return mixed
     */
    public function saveParam($key, $value)
    {
        $this->load('params');
        $param = $this->params()->firstOrNew(['key' => $key]);
        $param->value = $value;
        $param->save();

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

        return $param ? $param->value : $default;
    }

    /**
     * Morph param
     *
     * @param $key
     * @param $default
     * @param $morphClass
     * @return mixed
     * @throws \Exception
     */
    public function morphParam($key, $default = null, $morphClass = null)
    {
        $value = $this->param($key);

        $value = $value ? Morph::morph($morphClass ?: $key, $value) : null;

        return $value ?: $default;
    }

    /**
     * Return items associated with the given param
     *
     * @param $query
     * @param $key
     * @param $value
     * @return mixed
     */
    public function scopeHasParam($query, $key, $value = null)
    {
        $query->whereHas('params', function ($query) use ($key, $value) {
            $query->where('params.key', $key);
            if ($value) {
                $query->where('params.value', $value);
            }
        });

        return $query;
    }

    /**
     * Return items associated with the given param
     *
     * @param $query
     * @param $key
     * @return mixed
     */
    public function scopeHasDefinedParam($query, $key)
    {
        $query->whereHas('params', function ($query) use ($key) {
            $query->where('params.key', $key);
            $query->where('params.value', '!=', '');
            $query->whereNotNull('params.value');
        });

        return $query;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function paramQB()
    {
        return Param::query();
    }

    /**
     * @todo re-evaluate if this should be kept
     *
     * @param Param $param
     */
    public function purgeDuplicateParams(Param $param)
    {
        $qb = $this->paramQB();
        $qb->where('id', '!=', $param->id);
        $qb->where('paramable_type', $this->getMorphClass());
        $qb->where('paramable_id', $this->id);
        $qb->where('key', $param->key);

        foreach ($qb->get() as $duplicate) {
            $duplicate->delete();
        }
    }

    /**
     * @param null $key
     * @param null $default
     * @return mixed
     * @throws \Exception
     */
    public function getParamConfig()
    {
        return [];
    }

}