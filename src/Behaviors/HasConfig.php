<?php

namespace Belt\Core\Behaviors;

/**
 * Class HasConsole
 * @package Belt\Core\Behaviors
 */
trait HasConfig
{

    /**
     * @var array|mixed
     */
    public $config = [];

    /**
     * @var string
     */
    //protected $configPath;

    /**
     * @return string
     */
    abstract public function configPath();

    /**
     * @return array
     */
    public function configDefaults()
    {
        return [];
    }

    /**
     * @param array $config
     * @param bool $includeDefaults
     * @return array
     */
    public function setConfig($config = [], $includeDefaults = true)
    {
        $config = $config ? (array) $config : (array) config($this->configPath(), []);

        $defaults = $includeDefaults ? $this->configDefaults() : [];

        return $this->config = array_merge($defaults, $config);
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->config ?: $this->setConfig(null);
    }

    /**
     * @param $updated
     * @return array
     */
    public function mergeConfig($updated)
    {
        return $this->config = array_merge($this->getConfig(), $updated);
    }

    /**
     * @param null $key
     * @param null $default
     * @return mixed
     */
    public function config($key = null, $default = null)
    {
        $config = $this->getConfig();

        if ($key) {
            /* @todo uncomment below. seems better but might break something? */
            //return array_has($config, $key) ? $config[$key] : $default;
            return array_get($config, $key, $default);
        }

        return $config;
    }
}