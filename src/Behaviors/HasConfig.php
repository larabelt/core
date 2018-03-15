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
     * @return string
     */
    public function configPath()
    {
        return '';
    }

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
        $defaults = $includeDefaults ? $this->configDefaults() : [];

        $config = is_array($config) ? $config : config($this->configPath(), []);

        return $this->config = array_merge($defaults, $config);
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
     * @return array
     */
    public function getConfig()
    {
        return $this->config ?: $this->setConfig(null);
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
            return array_get($config, $key, $default);
        }

        return $config;
    }
}