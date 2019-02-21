<?php namespace Tests\Belt\Core\Unit\Helpers;

use Belt\Core\Helpers\SortHelper;

class SortHelperTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @covers \Belt\Core\Helpers\SortHelper::__construct
     * @covers \Belt\Core\Helpers\SortHelper::setOrders
     * @covers \Belt\Core\Helpers\SortHelper::setFromString
     * @covers \Belt\Core\Helpers\SortHelper::getByColumn
     */
    public function test()
    {

        # case 1
        $helper = new SortHelper('-places.rating,places.name');
        $order = $helper->getByColumn('name');
        $this->assertEquals('asc', $order->dir);

        # case 2
        $helper = new SortHelper('tag:44,places.name');
        $order = $helper->getByColumn('tag');
        $this->assertNotEmpty($order->params);
    }
}
