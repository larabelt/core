<?php

use Belt\Core\Helpers\SortHelper;

class SortHelperTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers \Belt\Core\Helpers\SortHelper::__construct
     * @covers \Belt\Core\Helpers\SortHelper::setOrders
     * @covers \Belt\Core\Helpers\SortHelper::setFromString
     * @covers \Belt\Core\Helpers\SortHelper::getByColumn
     */
    public function testisJson()
    {

        $helper = new SortHelper('-places.rating,places.name');
        $order = $helper->getByColumn('name');
        $this->assertEquals('asc', $order->dir);
    }
}
