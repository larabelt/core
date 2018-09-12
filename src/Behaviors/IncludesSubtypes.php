<?php

namespace Belt\Core\Behaviors;

use Belt\Core\Behaviors\Copyable;
use Belt\Core\Behaviors\ParamableInterface;
use Belt\Core\Behaviors\Paramable;
use Belt\Core\Helpers\ArrayHelper;
use Belt\Core\Observers\ParamableObserver;
use Belt\Core\Observers\IncludesSubtypesObserver;

/**
 * Class IncludesSubtypes
 * @package Belt\Content\Behaviors
 */
trait IncludesSubtypes
{

    use Copyable;

    use Paramable;

    /**
     * Binds events to subclass
     */
    public static function bootIncludesSubtypes()
    {
        static::observe(ParamableObserver::class);
        static::observe(IncludesSubtypesObserver::class);
    }

    /**
     * @param $value
     */
    public function setSubtypeAttribute($value)
    {
        $this->attributes['subtype'] = trim(strtolower($value));
    }

    /**
     * @param $value
     *
     * @return string
     */
    public function getSubtypeAttribute($value)
    {
        return $value ?: 'default';
    }

    /**
     * @return mixed
     */
    public function getSubtypeGroup()
    {
        return $this->getMorphClass();
    }

    /**
     * @return string
     */
    public function getSubtypeConfigPrefix()
    {
        return sprintf('belt.subtypes.%s', $this->getSubtypeGroup());
    }

    /**
     * @return string
     */
    public function getDefaultSubtypeKey()
    {
        $prefix = $this->getSubtypeConfigPrefix();

        $configs = (array) config($prefix);

        if (isset($configs['default']) || !count($configs)) {
            return 'default';
        }

        return array_keys($configs)[0];
    }

    /**
     * @param null $key
     * @param null $default
     * @return mixed
     * @throws \Exception
     */
    public function getSubtypeConfig($key = null, $default = null)
    {
        $prefix = $this->getSubtypeConfigPrefix();

        $config = config(sprintf('%s.%s', $prefix, $this->subtype));

        if (!$config) {
            $config = config(sprintf('%s.%s', $prefix, $this->getDefaultSubtypeKey()));
        }

        if (!$config) {
            //throw new \Exception("missing subtype config: $prefix.$this->subtype");
        }

        if ($key) {
            /* @todo uncomment below. seems better but might break something? */
            //return array_has($config, $key) ? $config[$key] : $default;
            return array_get($config, $key) ?: $default;
        }

        return (array) $config;
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function getSubtypeViewAttribute()
    {
        $config = $this->getSubtypeConfig();

        return is_array($config) ? array_get($config, 'path', array_get($config, 0)) : $config;
    }

    /**
     * @todo need other method to purge orphaned params
     */
    public function reconcileSubtypeParams()
    {
        if (!$this instanceof ParamableInterface) {
            return;
        }

        $this->load('params');

        $config = $this->getSubtypeConfig();

        $configParams = array_get($config, 'params', []);

        foreach ($configParams as $key => $configParam) {

            $default = '';
            $param = $this->params->where('key', $key)->first();

            $values = array_get($configParam, 'options', []);

            if (is_array($values) && $values) {
                $values = ArrayHelper::isAssociative($values) ? array_keys($values) : $values;
                $default = $values[0];
                if ($param && $param->value && !in_array($param->value, $values)) {
                    $param->update(['value' => $default]);
                }
            }

            if (!$param) {
                $this->params()->create(['key' => $key, 'value' => $default]);
            }

        }

        foreach ($this->params as $param) {
            if (!in_array($param->key, array_keys($configParams))) {
                $param->delete();
            }
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
        return $this->getSubtypeConfig('params');
    }

    /**
     * @param null $key
     * @param null $default
     * @return mixed
     * @throws \Exception
     */
    public function getParamGroupsConfig()
    {
        return $this->getSubtypeConfig('param_groups');
    }

    /**
     * Get config attribute
     *
     * @return mixed
     * @throws \Exception
     */
    public function getConfigAttribute()
    {
        return $this->getSubtypeConfig();
    }

    /**
     * @param null $key
     * @param null $default
     * @return mixed
     * @throws \Exception
     */
    public function config($key = null, $default = null)
    {
        return $this->getSubtypeConfig($key, $default);
    }

}