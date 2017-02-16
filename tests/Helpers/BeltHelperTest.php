<?php

use Belt\Core\Helpers\BeltHelper;
use Belt\Core\Testing\BeltTestCase;

use Illuminate\Contracts\Filesystem\Filesystem;

class BeltHelperTest extends BeltTestCase
{

    /**
     * @covers \Belt\Core\Helpers\BeltHelper::__toString
     * @covers \Belt\Core\Helpers\BeltHelper::baseDisk
     * @covers \Belt\Core\Helpers\BeltHelper::uses
     */
    public function test()
    {
        $helper = new BeltHelper();

        # __toString
        $this->assertTrue(is_string($helper->__toString()));

        # baseDisk
        $this->assertInstanceOf(Filesystem::class, $helper->baseDisk());

        # uses
        $this->assertTrue($helper->uses('core'));
        $this->assertTrue($helper->uses('Belt\Core\BeltCoreServiceProvider'));
        $this->assertFalse($helper->uses('tacos'));
    }
}
