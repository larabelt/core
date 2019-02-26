<?php namespace Tests\Belt\Core\Unit\Helpers;

use Belt\Core\Helpers\StrHelper;
use Belt\Core\Helpers\WindowConfigHelper;
use Tests\Belt\Core\BeltTestCase;

class WindowConfigHelperTest extends BeltTestCase
{

    /**
     * @covers \Belt\Core\Helpers\WindowConfigHelper::put
     * @covers \Belt\Core\Helpers\WindowConfigHelper::json
     */
    public function testconfig()
    {

        WindowConfigHelper::$config = [];

        # put
        $this->assertEmpty(array_get(WindowConfigHelper::$config, 'foo'));
        WindowConfigHelper::put('foo', 'bar');
        $this->assertEquals('bar', WindowConfigHelper::$config['foo']);
        WindowConfigHelper::put('foo', 'updated');
        $this->assertEquals('bar', WindowConfigHelper::$config['foo']);
        WindowConfigHelper::put('foo', 'updated', true);
        $this->assertEquals('updated', WindowConfigHelper::$config['foo']);

        # json
        $dump = WindowConfigHelper::json();
        $this->assertNotEmpty($dump);
        $this->assertTrue(StrHelper::isJson($dump));
    }
}
