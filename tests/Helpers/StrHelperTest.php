<?php

use Belt\Core\Helpers\StrHelper;

class StrHelperTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers \Belt\Core\Helpers\StrHelper::isJson
     */
    public function testisJson()
    {
        $this->assertFalse(StrHelper::isJson('not-json'));
        $this->assertTrue(StrHelper::isJson(json_encode('is-json')));
    }
}
