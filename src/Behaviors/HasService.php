<?php

namespace Belt\Core\Behaviors;

/**
 * Class HasConsole
 * @package Belt\Core\Behaviors
 */
trait HasService
{
    protected $service;

    /**
     * @return mixed
     * @throws \Exception
     */
    public function getServiceClass()
    {
        if (property_exists($this, 'serviceClass')) {
            return $this->serviceClass;
        }

        throw new \Exception('property serviceClass undefined');
    }

    /**
     * @param $service
     * @return mixed
     */
    public function setService($service)
    {
        return $this->service = $service;
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function getService()
    {
        return $this->service ?: $this->setService($this->initService());
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function initService()
    {
        $class = $this->getServiceClass();

        return new $class();
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function service()
    {
        return $this->getService();
    }

}