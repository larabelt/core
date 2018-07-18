<?php

use Belt\Core\BeltSingleton;

class BeltSingletonTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers \Belt\Core\BeltSingleton::publish
     * @covers \Belt\Core\BeltSingleton::seeders
     * @covers \Belt\Core\BeltSingleton::packages
     * @covers \Belt\Core\BeltSingleton::addPackage
     */
    public function test()
    {
        $singleton = new BeltSingleton();

        # publish
        $this->assertEmpty($singleton->publish());
        $singleton->publish('one');
        $this->assertTrue(in_array('one', $singleton->publish()));

        # seeders
        $this->assertEmpty($singleton->seeders());
        $singleton->seeders('one');
        $this->assertTrue(in_array('one', $singleton->seeders()));

        # addPackage, packages
        $this->assertEmpty($singleton->packages('test'));
        $singleton->addPackage('test', ['foo' => 'bar']);
        $this->assertNotEmpty($singleton->packages('test'));
        $this->assertNotEmpty($singleton->packages());
    }

}