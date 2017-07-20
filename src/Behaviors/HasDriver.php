<?php

namespace Belt\Core\Behaviors;

/**
 * Class HasConsole
 * @package Belt\Core\Behaviors
 */
trait HasDriver
{
    use HasConfig;

    /**
     * @var mixed
     */
    public $adapter;

    /**
     * Get default driver class
     *
     * @return string|null
     */
    abstract public function defaultDriverClass();

    /**
     * Get driver class
     *
     * @return mixed
     * @throws \Exception
     */
    public function driverClass()
    {
        $class = $this->config('class', $this->defaultDriverClass());

        if (!$class) {
            throw new \Exception('Model using Belt\Core\Behaviors\HasDriver is missing driver class');
        }

        return $class;
    }

    /**
     * Get adapter instance
     *
     * @return mixed
     */
    public function adapter()
    {
        return $this->adapter ?: $this->adapter = $this->initAdapter($this->driverClass());
    }

    /**
     * Instantiate adapter instance
     *
     * @param $class
     * @return mixed
     */
    public function initAdapter($class)
    {
        return new $class($this, ['config' => $this->config()]);
    }

}