<?php

use Ohio\Core\Base\Helper\OhioHelper;
use Ohio\Core\Base\Testing\OhioTestCase;

use Illuminate\Contracts\Filesystem\Filesystem;

class OhioHelperTest extends OhioTestCase
{

    /**
     * @covers \Ohio\Core\Base\Helper\OhioHelper::__toString
     * @covers \Ohio\Core\Base\Helper\OhioHelper::baseDisk
     * @covers \Ohio\Core\Base\Helper\OhioHelper::uses
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
        $this->assertTrue($helper->uses('Ohio\Core\Base\OhioCoreServiceProvider'));
        $this->assertFalse($helper->uses('tacos'));
    }
}
