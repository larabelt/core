<?php
namespace Ohio\Core\Testing;

use Mockery as m;
use Illuminate\Database\Eloquent\Model;

class BaseModelStub extends Model
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