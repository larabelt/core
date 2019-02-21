<?php namespace Tests\Belt\Core\Unit\Helpers;

use Belt\Core\Helpers\BeltHelper;
use Belt\Core\Tests\BeltTestCase;
use Illuminate\Contracts\Filesystem\Filesystem;

class BeltHelperTest extends BeltTestCase
{

    /**
     * @covers \Belt\Core\Helpers\BeltHelper::baseDisk
     */
    public function test()
    {
        $helper = new BeltHelper();

        # baseDisk
        $this->assertInstanceOf(Filesystem::class, $helper->baseDisk());

//        # uses
//        $this->assertTrue($helper->uses('core'));
//        $this->assertTrue($helper->uses('Belt\Core\BeltCoreServiceProvider'));
//        $this->assertFalse($helper->uses('tacos'));
//
//        # enabled
//        $enabled = $helper->enabled();
//        $this->assertTrue(in_array('core', array_keys($enabled)));
//        $this->assertEquals($enabled, $helper->enabled());
    }
}
