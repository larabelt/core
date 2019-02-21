<?php namespace Tests\Belt\Core\Unit;

use Belt\Core\BeltSingleton;
use Belt\Core\Tests\BeltTestCase;

class helpersTest extends BeltTestCase
{

    public function test()
    {
        $this->assertInstanceOf(BeltSingleton::class, belt());
    }
}
