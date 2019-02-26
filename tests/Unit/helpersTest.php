<?php namespace Tests\Belt\Core\Unit;

use Belt\Core\BeltSingleton;
use Tests\Belt\Core\BeltTestCase;

class helpersTest extends BeltTestCase
{

    public function test()
    {
        $this->assertInstanceOf(BeltSingleton::class, belt());
    }
}
