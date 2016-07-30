<?php
namespace Ohio\Core\Base\Service;

use Illuminate\Support\Collection;

class NgService
{

    static $items;

    public function __construct()
    {
        static::$items = new Collection();
    }

    public function push($value)
    {

        static::$items->push($value);

        return $this;
    }

    public function all()
    {

        return static::$items->all();
    }

}