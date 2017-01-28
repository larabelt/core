<?php

use Mockery as m;
use Ohio\Core\Helpers\DebugHelper;
use Illuminate\Database\Eloquent\Model;

class DebugHelperTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Ohio\Core\Helpers\DebugHelper::getSql
     */
    public function test()
    {
        $qb = DebugHelperTestStub::query();

        $sql = DebugHelper::getSql($qb);

        $this->assertEquals('select my_table.id from my_table where name = test', $sql);
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
