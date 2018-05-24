<?php

use Belt\Core\Helpers\StrHelper;

class StrHelperTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @covers \Belt\Core\Helpers\StrHelper::isJson
     * @covers \Belt\Core\Helpers\StrHelper::strToArguments
     * @covers \Belt\Core\Helpers\StrHelper::strToArray
     * @covers \Belt\Core\Helpers\StrHelper::normalizeUrl
     */
    public function testisJson()
    {

        //StrHelper::strToArray("['foo'=>'bar', 'two']");
        //StrHelper::strToArray('array("foo", 2)');

        # isJson
        $this->assertFalse(StrHelper::isJson('not-json'));
        $this->assertTrue(StrHelper::isJson(json_encode('is-json')));

        # strToArguments
        $arguments = StrHelper::strToArguments('foo, bar', 3);
        $this->assertEquals('foo', $arguments[0]);
        $this->assertEquals('bar', $arguments[1]);
        $this->assertEquals(null, $arguments[2]);
        $this->assertFalse(isset($arguments[3]));

        # strToArguments w/array
        $arguments = StrHelper::strToArguments("test, ['foo'=>'bar']");
        $this->assertEquals(['foo' => 'bar'], $arguments[1]);

        # strToArguments w/mal-formed array
        //$arguments = StrHelper::strToArguments("test, ['foo'=>'bar']asdf");
        //$this->assertEquals(null, $arguments[1]);

        # normalizeUrl
        $this->assertEquals('/foo/bar', StrHelper::normalizeUrl('foo/bar/'));
        $this->assertEquals('http://foo.bar', StrHelper::normalizeUrl('http://foo.bar/'));
    }
}
