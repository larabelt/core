<?php

use Ohio\Core\Helpers\OhioHelper;

class helpersTest extends \PHPUnit_Framework_TestCase
{

    public function test()
    {
        $this->assertInstanceOf(OhioHelper::class, ohio());
    }
}
