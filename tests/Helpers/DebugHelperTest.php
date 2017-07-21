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
