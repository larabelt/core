<?php

use Mockery as m;
use Belt\Core\Helpers\DebugHelper;
use Illuminate\Database\Eloquent\Model;

class DebugHelperTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Helpers\DebugHelper::buffer
     * @covers \Belt\Core\Helpers\DebugHelper::getSql
     * @covers \Belt\Core\Helpers\DebugHelper::varExportShort
     */
    public function test()
    {
        # getSql
        $qb = DebugHelperTestStub::query();
        $sql = DebugHelper::getSql($qb);
        $this->assertEquals('select my_table.id from my_table where name = test', $sql);

        # buffer
        $response = DebugHelper::buffer(['foo' => 'bar']);
        $this->assertTrue(str_contains($response, ['foo']));
        $this->assertTrue(str_contains($response, ['bar']));
        $this->assertEquals('foo', DebugHelper::buffer('foo'));

        # varExportShort (return)
        $response = DebugHelper::varExportShort(['foo' => 'bar']);
        $this->assertTrue(str_contains($response, ['[', ']']));

        # varExportShort (object)
        $object = new \stdClass();
        $object->foo = 'bar';
        $response = DebugHelper::varExportShort($object);
        $this->assertTrue(str_contains($response, ['[', ']']));

        # varExportShort (echo)
        ob_start();
        DebugHelper::varExportShort(['foo' => 'bar'], false);
        $response = ob_get_contents();
        ob_end_clean();
        $this->assertTrue(str_contains($response, ['[', ']']));
    }
}

class DebugHelperTestStub extends Model
{
    public function newQuery()
    {
        $mock = m::mock('Illuminate\Database\Eloquent\Builder');
        $mock->shouldReceive('toSql')->once()->andReturn('select ? from ? where ? = ?');
        $mock->shouldReceive('getBindings')->once()->andReturn([
            'my_table.id',
            'my_table',
            'name',
            'test',
        ]);

        return $mock;
    }
}
