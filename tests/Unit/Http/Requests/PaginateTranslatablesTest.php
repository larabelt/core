<?php namespace Tests\Belt\Core\Unit\Http;

use Belt\Core\Http\Requests\PaginateTranslatables;
use Belt\Core\Tests;
use Illuminate\Database\Eloquent\Builder;
use Mockery as m;

class PaginateTranslatablesTest extends Tests\BeltTestCase
{

    use Tests\CommonMocks;

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Http\Requests\PaginateTranslatables::modifyQuery
     */
    public function test()
    {
        $qbMock = m::mock(Builder::class);
        $qbMock->shouldReceive('where')->once()->with('translatable_id', 1);
        $qbMock->shouldReceive('where')->once()->with('translatable_type', 'params');

        $paginateRequest = new PaginateTranslatables(['translatable_id' => 1, 'translatable_type' => 'params']);

        # modifyQuery
        $paginateRequest->modifyQuery($qbMock);
    }

}