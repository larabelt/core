<?php

use Ohio\Core\Base\Pagination\BaseLengthAwarePaginator;

use Mockery as m;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Ohio\Core\Base\Http\Requests\BasePaginateRequest;

class BaseLengthAwarePaginatorTest extends \PHPUnit_Framework_TestCase
{
    protected function addMockConnection($model)
    {
        $model->setConnectionResolver($resolver = m::mock('Illuminate\Database\ConnectionResolverInterface'));
        $resolver->shouldReceive('connection')->andReturn(m::mock('Illuminate\Database\Connection'));
        $model->getConnection()->shouldReceive('getQueryGrammar')->andReturn(m::mock('Illuminate\Database\Query\Grammars\Grammar'));
        $model->getConnection()->shouldReceive('getPostProcessor')->andReturn(m::mock('Illuminate\Database\Query\Processors\Processor'));
    }

    public function tearDown()
    {
        m::close();

        Illuminate\Database\Eloquent\Model::unsetEventDispatcher();
        Carbon\Carbon::resetToStringFormat();
    }

    public function test__construct()
    {

        $model = new EloquentModelStub2();
        //$this->addMockConnection($model);

        $qb = $model->newQuery();

        $qb->where('asdf', 1);

        $request = new BasePaginateRequest();

        //$paginator = new BaseLengthAwarePaginator($qb, $request);
    }
}

class EloquentModelStub2 extends Model
{
    public $connection;
    protected $table = 'stub';
    protected $guarded = [];

    public function newQuery()
    {
        spl_autoload_call('Illuminate\Database\Eloquent\Builder');
        $mock = m::mock('Illuminate\Database\Eloquent\Builder');
        $mock->shouldReceive('where')->once()->with('asdf', 1);

        return $mock;
    }


}
