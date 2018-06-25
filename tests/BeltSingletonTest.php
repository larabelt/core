<?php

use Belt\Core\BeltSingleton;

class BeltSingletonTest extends \PHPUnit\Framework\TestCase
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

        # addPackage
        $singleton->addPackage('foo', ['bar']);

        # packages
        $this->assertTrue(array_has($singleton->packages(), 'foo'));
        $this->assertEquals(['bar'], $singleton->packages('foo'));
    }

}