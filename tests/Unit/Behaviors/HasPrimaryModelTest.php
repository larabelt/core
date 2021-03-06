<?php namespace Tests\Belt\Core\Unit\Behaviors;

use Belt\Core\Behaviors\HasPrimaryModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Mockery as m;

class HasPrimaryModelTest extends \PHPUnit\Framework\TestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Behaviors\HasPrimaryModel::instance
     * @covers \Belt\Core\Behaviors\HasPrimaryModel::query
     * @covers \Belt\Core\Behaviors\HasPrimaryModel::table
     */
    public function test()
    {
        $service = new HasPrimaryModelService();

        $this->assertInstanceOf(HasPrimaryModelStub::class, $service->instance());
        $this->assertInstanceOf(Builder::class, $service->query());
        $this->assertEquals('test', $service->table());
    }

}

class HasPrimaryModelStub extends Model
{
    protected $table = 'test';

    /**
     * @return m\MockInterface
     */
    public function newQuery()
    {
        return m::mock('Illuminate\Database\Eloquent\Builder');
    }
}

class HasPrimaryModelService
{
    use HasPrimaryModel;

    protected static $primaryModel = HasPrimaryModelStub::class;

}