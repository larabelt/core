<?php

use Belt\Core\Helpers\BeltHelper;

class helpersTest extends \PHPUnit\Framework\TestCase
{

    public function test()
    {
        $this->assertInstanceOf(BeltHelper::class, belt());
    }
}
