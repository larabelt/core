<?php

use Belt\Core\BeltSingleton;
use Belt\Core\Testing\BeltTestCase;

class helpersTest extends BeltTestCase
{

    public function test()
    {
        $this->assertInstanceOf(BeltSingleton::class, belt());
    }
}
