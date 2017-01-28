<?php

use Ohio\Core\Helpers\OhioHelper;
use Ohio\Core\Testing\OhioTestCase;

use Illuminate\Contracts\Filesystem\Filesystem;

class OhioHelperTest extends OhioTestCase
{

    /**
     * @covers \Ohio\Core\Helpers\OhioHelper::__toString
     * @covers \Ohio\Core\Helpers\OhioHelper::baseDisk
     * @covers \Ohio\Core\Helpers\OhioHelper::uses
     */
    public function test()
    {
        $helper = new OhioHelper();

        # __toString
        $this->assertTrue(is_string($helper->__toString()));

        # baseDisk
        $this->assertInstanceOf(Filesystem::class, $helper->baseDisk());

        # uses
        $this->assertTrue($helper->uses('core'));
        $this->assertTrue($helper->uses('Ohio\Core\OhioCoreServiceProvider'));
        $this->assertFalse($helper->uses('tacos'));
    }
}
