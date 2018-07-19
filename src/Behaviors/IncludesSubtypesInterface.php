<?php
namespace Belt\Core\Behaviors;

/**
 * Interface IncludesSubtypesInterface
 * @package Belt\Core\Behaviors
 */
interface IncludesSubtypesInterface
{

    /**
     * @param $value
     */
    public function setSubtypeAttribute($value);

    /**
     * @param $value
     *
     * @return string
     */
    public function getSubtypeAttribute($value);

    /**
     * @return string
     */
    public function getSubtypeConfigPrefix();

    /**
     * @return string
     */
    public function getDefaultSubtypeKey();

    /**
     * @return mixed
     */
    public function getSubtypeGroup();

    /**
     * @param null $key
     * @param null $default
     * @return mixed
     * @throws \Exception
     */
    public function getSubtypeConfig($key = null, $default = null);

    /**
     * @return mixed
     * @throws \Exception
     */
    public function getSubtypeViewAttribute();

    /**
     * @todo need other method to purge orphaned params
     */
    public function reconcileSubtypeParams();

}