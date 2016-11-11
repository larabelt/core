<?php

use Ohio\Core\Base\Helper\OhioHelper;

class helpersTest extends \PHPUnit_Framework_TestCase
{

    public function test()
    {
        $this->assertInstanceOf(OhioHelper::class, ohio());
    }
}
