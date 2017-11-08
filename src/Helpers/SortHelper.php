<?php

namespace Belt\Core\Helpers;

/**
 * Class SortHelper
 * @package Belt\Core\Helpers
 */
class SortHelper
{
    /**
     * @var array
     */
    private $orders = [];

    /**
     * SortHelper constructor.
     * @param string $str
     */
    public function __construct($str = null)
    {
        if ($str) {
            $this->setFromString($str);
        }
    }

    /**
     * @param $orders
     */
    public function setOrders($orders)
    {
        $this->orders = $orders;
    }

    /**
     * @param $str
     */
    public function setFromString($str)
    {
        $orders = [];

        foreach (explode(',', $str) as $dtc) {

            $params = [];
            if (str_contains($dtc, ':')) {
                $bits = explode(':', $dtc);
                $dtc = $bits[0];
                $params = explode(' ', str_replace('+', ' ', $bits[1]));
            }

            $tc = explode('.', ltrim($dtc, '-'));

            $order = new \stdClass();
            $order->dir = substr($dtc, 0, 1) == '-' ? 'desc' : 'asc';
            $order->table = isset($tc[1]) ? $tc[0] : null;
            $order->column = $tc[1] ?? $tc[0];
            $order->tc = $order->table ? "$order->table.$order->column" : $order->column;
            $order->params = $params;

            $orders[$order->tc] = $order;
        }

        $this->setOrders($orders);
    }

    /**
     * @param $column
     * @return mixed
     */
    public function getByColumn($column)
    {
        $first = array_first($this->orders, function ($order) use ($column) {
            return $order->column == $column;
        });

        return $first;
    }

}