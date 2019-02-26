<?php namespace Tests\Belt\Core\Unit;

use Belt\Core\BeltSingleton;
use Tests\Belt\Core;

class BeltSingletonTest extends \Tests\Belt\Core\BeltTestCase
{
    /**
     * @covers \Belt\Core\BeltSingleton::publish
     * @covers \Belt\Core\BeltSingleton::seeders
     * @covers \Belt\Core\BeltSingleton::packages
     * @covers \Belt\Core\BeltSingleton::addPackage
     * @covers \Belt\Core\BeltSingleton::uses
     * @covers \Belt\Core\BeltSingleton::guessPackage
     * @covers \Belt\Core\BeltSingleton::version
     */
    public function test()
    {
        $singleton = belt();

        # publish
        $singleton->publish('one');
        $this->assertTrue(in_array('one', $singleton->publish()));

        # seeders
        $singleton->seeders('one');
        $this->assertTrue(in_array('one', $singleton->seeders()));

        # addPackage
        $singleton->addPackage('foo', ['bar']);

        # packages
        $this->assertTrue(array_has($singleton->packages(), 'foo'));
        $this->assertEquals(['bar'], $singleton->packages('foo'));

        # uses
        $this->assertTrue($singleton->uses('core'));
        $this->assertTrue($singleton->uses('content'));
        $this->assertFalse($singleton->uses('missing'));

        # guessPackage
        $this->assertEquals('core', $singleton->guessPackage(BeltSingleton::class));

        # version
        $this->assertEquals('2', $singleton->version(1));
        $this->assertEquals('2.0', $singleton->version(2));
        $this->assertEquals(\Belt\Core\BeltCoreServiceProvider::VERSION, $singleton->version(3));
    }

}