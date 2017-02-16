<?php

use Belt\Core\Helpers\BeltHelper;

class helpersTest extends \PHPUnit_Framework_TestCase
{

    public function test()
    {
        $this->assertInstanceOf(BeltHelper::class, belt());
    }
}
