<?php namespace Tests\Belt\Core\Unit\Http;

use Belt\Core\Http\Requests\PaginateParamables;
use Tests\Belt\Core;
use Illuminate\Database\Eloquent\Builder;
use Mockery as m;

class PaginateParamablesTest extends \Tests\Belt\Core\BeltTestCase
{

    use \Tests\Belt\Core\Base\CommonMocks;

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Http\Requests\PaginateParamables::modifyQuery
     */
    public function test()
    {
        $qbMock = m::mock(Builder::class);
        $qbMock->shouldReceive('where')->once()->with('paramable_id', 1);
        $qbMock->shouldReceive('where')->once()->with('paramable_type', 'users');

        $paginateRequest = new PaginateParamables(['paramable_id' => 1, 'paramable_type' => 'users']);

        # modifyQuery
        $paginateRequest->modifyQuery($qbMock);
    }

}