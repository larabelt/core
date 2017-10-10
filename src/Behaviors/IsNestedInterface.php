<?php namespace Belt\Core\Behaviors;

/**
 * Interface IsNestedInterface
 * @package Belt\Core\Behaviors
 */
interface IsNestedInterface
{

    /**
     * @return array
     */
    public function getHierarchyAttribute();

    /**
     * @param string $glue
     * @return string
     */
    public function getNestedName($glue = ' > ');

    /**
     * @return string
     */
    public function getNestedNameAttribute();

}