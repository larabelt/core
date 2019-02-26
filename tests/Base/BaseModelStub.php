<?php
namespace Tests\Belt\Core\Base;

use Mockery as m;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseModelStub
 * @package Tests\Belt\Core
 */
class BaseModelStub extends Model
{
    /**
     * @return m\MockInterface
     */
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